<?php
namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
class MachineLearningService
{
    function getAiValueStability($allTimes) {
        $url = "http://127.0.0.1:5000/predict";
        if (count($allTimes) > 3) {
            try {
                $data = array("data" => $allTimes);
                $data_string = json_encode($data);

                // Create connection
                $ch = curl_init($url);

                // Set request method
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

                // Set request headers
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($data_string),
                        'Content-Language: en-US')
                );

                // Enable writing data to the connection
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                // Execute the request
                $result = curl_exec($ch);

                // Close connection
                curl_close($ch);

                // Decode JSON response
                $jsonObject = json_decode($result, true);

                // Log response
              //  echo "Response: " . $result;

                // Return feedback value
                return $jsonObject['feedback'];

            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
        return 0;
    }
}


