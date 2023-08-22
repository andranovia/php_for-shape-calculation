<?php
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$shape = $data['shape'];
$calculation = $data['calculation'];

$result = 0;

if ($shape === 'cube') {
  $side = $data['side'];

  if ($calculation === 'surface_area') {
    $result = 6 * pow($side, 2);
  } elseif ($calculation === 'volume') {
    $result = pow($side, 3);
  }



} elseif ($shape === 'rectangular_prism') {
  $length = $data['length'];
  $width = $data['width'];
  $height = $data['height'];

  if ($calculation === 'surface_area') {
    $result = 2 * ($length * $width + $length * $height + $width * $height);
  } elseif ($calculation === 'volume') {
    $result = $length * $width * $height;
  }


} else if ($shape === 'prism_triangle') {
  $prism_height = $data['prism_triangle_height'];
  $pedestal = $data['pedestal'];
  $height = $data['height'];

  if ($calculation === 'volume') {
    $result = ($pedestal * $height / 2) * $prism_height;
  } elseif ($calculation === 'surface_area') {
    $base_area = ($pedestal * $prism_height) / 2;
    $lateral_surface_area = 3 * ($pedestal * $height);
    $result = 2 * $base_area + $lateral_surface_area;
  }
} else if ($shape === 'sphere') {
  $radius = $data['radius'];
  $phi = 3.14;

  if ($calculation === 'volume') {
    $resultAbsolute = (4 / 3) * $phi * pow($radius, 3);
    $result = round($resultAbsolute, 2);

  } else if ($calculation === 'surface_area') {


    $resultAbsolute = 4 * $phi * pow($radius, 2);
    $result = round($resultAbsolute, 2);
  }
} else if ($shape === 'cone') {
  $radius = $data['radius'];
  $height = $data['height'];

  if ($calculation === 'volume') {
    $phi = 3.14;

    $resultAbsolute = (1 / 3) * $phi * pow($radius, 2) * $height;
    $result = round($resultAbsolute, 2);
  } else if ($calculation === 'surface_area') {
    $phi = 3.14; 
    $slantHeight = sqrt(pow($radius, 2) + pow($height, 2));
    

    $resultAbsolute = $phi * $radius * ($radius + $slantHeight);
    $result = round($resultAbsolute, 2); 
  }
}


$response = ['result' => $result];
echo json_encode($response);
?>