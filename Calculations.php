<?php
  $filename = "calculations.csv";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header("Content-type: application/json");

    // Get the calculated result from the body
    $calcResult = isset($_POST["result"])
      ? $_POST["result"]
      : "";

    // Get the current datetime and format to MySQL
    $now = new DateTime();
    $createdAt = $now->format("Y-m-d H:i:s");

    // Get IP address and (if set) proxy ip
    $ip = $_SERVER["REMOTE_ADDR"];
    $forwardedIp = isset($_SERVER["HTTP_X_FORWARDED_FOR"])
      ? $_SERVER["HTTP_X_FORWARDED_FOR"]
      : "";

    // Get user agent and browser
    $userAgent = $_SERVER["HTTP_USER_AGENT"];

    // TODO: Need to sort browscap.ini
    // $browser = get_browser(null, true);
    $browser = "";

    // Configure rows and values
    $keys = ["ip", "forwarded_ip", "user_agent", "browser", "result", "created_at"];

    $values = array (
      [$ip, $forwardedIp, $userAgent, $browser, $calcResult, $createdAt]
    );

    if (!file_exists($filename)) {
      $handle = fopen($filename, "a");
      fputcsv($handle, $keys);
    } else {
      $handle = fopen($filename, "a");
    }

    foreach ($values as $row) {
      fputcsv($handle, $row);
    }

    fclose($handle);

    $arr = array (
      "success" => true,
      "message" =>"Your result has been saved.",
      "errors" => [],
      "row_data" => array_combine($keys, $values[0])
    );

    echo json_encode($arr);
  }

  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $row = 1;
    $keys = array();
    $values = array();

    if (file_exists($filename)) {
      if (($handle = fopen($filename, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
          $count = count($data);

          if ($row === 1) {
            for ($cell=0; $cell < $count; $cell++) {
              $keys[] = $data[$cell];
            }
          } else {
            $rowValues = array();
            for ($cell=0; $cell < $count; $cell++) {
              $rowValues[] = $data[$cell];
            }
            $values[] = $rowValues;
          }

          $row++;
        }

        fclose($handle);
      }
    }

    $arr = array();

    for ($i = 0; $i < count($values); $i++) {
      $arr[] = (object) array_combine($keys, $values[$i]);
    }

    function sortByCreatedAt($a, $b) {
      return strtotime($a->created_at) < strtotime($b->created_at);
    }

    usort($arr, "sortByCreatedAt");

    print("<pre>" . print_r($arr, true) . "</pre>");
  }
?>