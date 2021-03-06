<?php
require('dbconfig.php');
require('statistics.php');

$bottom = $mysqli->real_escape_string($_GET['bottom']);
$number = $mysqli->real_escape_string($_GET['number']);

$statistics = new Statistics($mysqli, $bottom, $number);
$i = 0;
if(!$statistics->getFullList()->count()){
    echo "<p>Még senki sem adott választ.</p>";
    exit();
}

/* tablazat */
echo "<table cellpadding='10'>";
echo "<thead>
        <th>Sr.</th>
        <th>Kérdés</th>
        <th>Helyesség</th>
        <th>Név</th>
        <th>Dátum</th>
        <th>Nehézség</th>
      </thead>";

foreach ($statistics->getFullList() as $answer) {
    if(isset($_GET['qid'])) {
        if($_GET['qid'] != $answer['id_question']) continue;
    }

    if($i % 2 == 0) echo "<tr id='even_table_row'>";
    else echo "<tr id='odd_table_row'>";

    echo "<td>" . $answer['number'] . " </td><td>" . $answer['question'] . "</td><td>" . ($answer['correct'] == 1 ? "helyes" : "helytelen") . "</td><td>" . $answer['name'] . "</td>
            <td>" . $answer['date'] . "</td><td>" . $answer['difficulty'] . "</td>";

    echo "</tr>";
    ++$i;
}
echo "</table>";

if($i == 0) {
    echo "<p>Erre a kérdésre még senki sem válaszolt.</p>";
}
$mysqli->close();
