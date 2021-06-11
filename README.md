### php_virus
A virus I wrote in PHP

# Overview:

Php as we know is rather infamous as it is easy to write insecure code in. It is also rather easy for a virus to infect a PHP file given how website in PHP are often written. And so PHP is the perfect language to write a web virus in.

## about the virus:
Basically, this virus infects all your php files and will copy itself onto them and the process repeats.
I hope to be adding payloads(I was thinking using JSON) to this in the future.
Feel free to contribute to it and build on it if you please.

The virus encrypts itself using the Rijndael algorithm with a unique key every time it infects a new file. This makes it harder for antivirus software to detect the virus and also makes it more difficult to clean up.

### note:
I won't deny, this virus has been heavily inspired by the video: 
Writing Viruses for fun and not for profit.
Link: https://www.youtube.com/watch?v=2Ra1CCG8Guo

The speaker gives a detailed explanation about what viruses are and how they spread and affect computers.
I have built upon that work and will keep pushing updates, as and when I get the time. 

## Warning:

### Please do not use this virus to cause any harm. I am not responsible for any misuse of the code.

### Also, please do not run this on your personal server/localhost, please run it in a virtual environment! The virus will infect all PHP files on your machine and cleaning it up is a pain.
