----
## PHP class that converts numbers  (Croatian currency)  to a letters.

It is adjusted for Croatian language and currency (kuna/lipa) due to specific grammar.  
It might be used for some similar group of languages, changing the names of numbers.  
Typical usage is in creating invoices where amount is shown as a number and as letters.

Class is working till a number of million (`999999.99`). If you need a larger number, congratulation :-).  
It may be adopt for a larger amounts.

Decimal point can be a point `.` or a comma `,`   
Number shall be with two decimal points, such as `12500.55`.

----
## Usage
Usage is simple.
If we called a class: `Class_brojuslova.php`, code for creating an object can be as followed:

    <?php
        require_once 'Class_brojuslova.php';
        $a = 500;
        
        $obj = new Class_brojuslova.php();
        $number_letters = $obj->upravljac($a);
        
        echo number_letters; // print: petstokuna
    ?>

If you use a framework, example for *CodeIgniter* within some controller method would be as following (the class would live in a library section):

    <?php
 
        // initialization of class class_brojuslova from a library
        $this->load->library('class_brojuslova');
        $brojzaslova = "500.35";

        // conversion of number in a letter
        $data['sumslovima'] = $this->class_brojuslova->upravljac($brojzaslova);
    
    ?>
