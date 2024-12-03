DISCLAMER
	IF YOUR PROGRAMER BREAKS ANYTHING FROM THE FILES WE HAVE PROVIDED, WE WILL NOT BE HELD RESPONSIBLE!!!



Your login Credentials

Username: om.aprtll 
Password: OPManager1!


Extract all files inside your System Directory



Import the sql file to your database. 

The database name is 'apartelle_db', but you can change it into something else just don't forget to also change the database name on connection.php inside the connection folder

once the database is imported, don't forget to input a working GMAIL on the email column



//// EmailLogin.php ////

on line 211 (window.location.href), change 'homepage.php' to the file name of your Home Page.



///// For all of the provided PHP files (Only if applicable) /////

Change header Location of $_SESSION['user_id'] from 'homepage.php' to the name of your Home Page.




///// Dashboard / Homepage and all of the pages that are requires the user to be logged on /////

////// Add the following code at the top most line of your PHP codes /////

include_once("connection/connection.php");
$con = connection(); // if you have fetching SQL functionalities that require a database connection, you might have to include these 2 lines there as well.

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: adminlogin.php");
    exit();
    
}


////// IF YOUR SYSTEM REQUIRES TO SHOW THE JOB TITLES OF EACH SYSTEM MANAGER, USE THE FOLLOWING FORMAT (Change the values if necessary) /////

// Format of the job title
        $jobFormatted = '';
        switch ($row['job']) {
            case 'admin':
                $jobFormatted = 'Administrator';
                break;
            case 'finance':
                $jobFormatted = 'Finance Manager';
                break;
            case 'hr':
                $jobFormatted = 'HR Manager';
                break;
            case 'om':
                $jobFormatted = 'Operational Manager';
                break;
            default:
                $jobFormatted = 'Unknown'; // Default for unmatched values
                break;
        }