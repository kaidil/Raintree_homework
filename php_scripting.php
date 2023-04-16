<!DOCTYPE html>
<html>
<body>

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";


// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}


//a) Display the following columns for each patient to the console:
$sql="SELECT patient.pn, patient.last, patient.first, insurance.iname, DATE_FORMAT(insurance.from_date, '%m-%d-%y') AS `from_date`, DATE_FORMAT(insurance.to_date, '%m-%d-%y') AS `to_date` FROM patient
INNER JOIN insurance ON patient._id=insurance.patient_id ORDER BY patient.last;";


$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<br>". $row["pn"]. ", ". $row["last"]. ", " . $row["first"] . ", " . $row["iname"]. ", " . $row["from_date"] . ", " . $row["to_date"]. "<br>";
    }
} else {
    echo "0 results";
}


/*b) Create statistics about how many times (in count and in percentages with two decimal points
from total) each letter occurs in first and last names. This has to be considered as case insensitive
and only considering alphabetic characters. Do not output letters, which do not occur in the strings.
Output has to be sorted alphabetically ascending order.*/
$sql = "SELECT last, first FROM patient";

$result = mysqli_query($conn, $sql);

// Initialize an empty frequency array
$freq = array();

if (mysqli_num_rows($result) > 0) {
  // Loop through each row of the result set
  while($row = mysqli_fetch_assoc($result)) {
    // Concatenate first and last name
    $name = $row['last'] . $row['first'];

    // Convert to lowercase
    $name = strtolower($name);

    // Count frequency of each letter
    $freq_row = array_count_values(str_split(preg_replace('/[^a-z]/i', '', $name)));

    // Merge the frequency arrays
    $freq = array_merge($freq, $freq_row);
  }

  // Calculate total number of letters
  $total_letters = array_sum($freq);

  // Sort the frequency array alphabetically
  ksort($freq);

  // Loop through the frequency array and print the output
  foreach($freq as $letter => $count) {
    $percentage = number_format(($count / $total_letters) * 100, 2);
    echo strtoupper($letter) . "\t" . $count . "\t" . $percentage . " %" . PHP_EOL . "<br>";
  }
} else {
  echo "0 results";
}
        
mysqli_close($conn);
?>

</body>
</html>