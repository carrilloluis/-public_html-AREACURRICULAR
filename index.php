<?php

// Autoload files using composer
require_once __DIR__ . '/vendor/autoload.php';

// Use this namespace
use Steampixel\Route;

define('SERVER_DB', 'localhost');
define('PORT_DB', 3306);
define('DATABASE_NAME', 't3st');
define('DSN_DB', 'mysql:host=' . SERVER_DB . ';dbname=' . DATABASE_NAME . ';charset=utf8');
define('USER_DB', 'admin');
define('PASSWORD_DB', 'r00t');
define('KEY_CRYPT', 'gHfKxh%zjqC7ZMKAcY@B(fC(aC0Opv9Q');
define('STANDARD_HEADER', 'Content-Type: application/json; charset="UTF-8"');
define('VERSION', '0.0.1.13');

function
getConnection():object
{
  try {
    $conn = new PDO ( DSN_DB, USER_DB, PASSWORD_DB );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $error) {
    http_response_code(500);
    die(json_encode( array('error' => $error->getMessage() )));
  } catch(Exception $errorConnection) {
    http_response_code(500);
    die(json_encode( array('error' => $errorConnection->getMessage() )));
  }
  return $conn;
}

function
uuid():string
{
  return sprintf('%08x-%04x-%04x-%02x%02x-%012x',
    mt_rand(),
    mt_rand(0, 65535),
    bindec(substr_replace(
      sprintf('%016b', mt_rand(0, 65535)), '0100', 11, 4)
    ),
    bindec(substr_replace(sprintf('%08b', mt_rand(0, 255)), '01', 5, 2)),
    mt_rand(0, 255),
    mt_rand()
  );
}

# -----------------------------------------------------------------------------------------------------------------
Route::add('/_Curricular_Area/v1/([a-zA-Z0-9]{2})/', function( $level_id )
{
  /**
   * Set/Open database connection
   */
  $conn_ = getConnection();

  /**
   * SQL string query
   */
  $strQuery = "
    SELECT C.`id` AS id, C.`level_id` AS level, T.`name` AS name, C.`is_active` AS enable
    FROM `CurricularArea_` C
    LEFT JOIN `TypeCourse_` T ON C.`course_id`=T.`id`
    WHERE C.`level_id`=UCASE(?) AND C.`is_active`=b'1' AND T.`is_active`=b'1';
  ";

  /**
   * Send a SQL request
   */
  try {
      $stmt = $conn_->prepare($strQuery);
      $stmt->bindParam(1, $level_id, PDO::PARAM_STR, 2);
      $stmt->execute();
      $sizeResultSet = $stmt->rowCount();
  } catch(Exception $error) {
      http_response_code(500);
      header(STANDARD_HEADER);
      die(json_encode([ 'error' => $error->getMessage() ]));
  }

  /**
   * Generate the SQL Resultset
   */
  $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);

  /**
   * Close database connection
   */
  $conn_ = null;
  unset($conn_);

  /**
   * Build JSON response [status=200, CORS=enabled]
   */
  http_response_code(200);
  header(STANDARD_HEADER);
  echo json_encode( [
    'data' => $sizeResultSet === 0 ? [] : $rs,
  ]);
}, 'GET');

# -----------------------------------------------------------------------------------------------------------------
Route::add('/_Curricular_Area/v1/_/([a-zA-Z0-9]{2})/([0-9]{1,2})/', function( $level_id, $grade_id )
{
  $conn_ = getConnection();
  $strQuery = "
    SELECT C.`id` AS id, C.`level_id` AS level, T.`name` AS name, C.`is_active` AS enable
    FROM `CurricularArea_` C
    LEFT JOIN `TypeCourse_` T ON C.`course_id`=T.`id`
    WHERE C.`level_id`=UCASE(?) AND C.`grade_id`=? AND C.`is_active`=b'1' AND T.`is_active`=b'1';
  ";
  try {
    $stmt = $conn_->prepare($strQuery);
    $stmt->bindParam(1, $level_id, PDO::PARAM_STR, 2);
    $stmt->bindParam(2, $grade_id, PDO::PARAM_INT);
    $stmt->execute();
    $sizeResultSet = $stmt->rowCount();
  } catch(Exception $error) {
    http_response_code(500);
    header(STANDARD_HEADER);
    die(json_encode([ 'error' => $error->getMessage() ]));
  }

  $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $conn_ = null;
  unset($conn_);

  http_response_code(200);
  header(STANDARD_HEADER);
  echo json_encode( [
    'data' => $sizeResultSet === 0 ? [] : $rs,
  ]);
}, 'GET');

# -----------------------------------------------------------------------------------------------------------------
Route::add('/_Curricular_Area/v1/__version__/', function()
{
  header(STANDARD_HEADER);
  echo json_encode( [
    'project' => 'Proyecto CREE / GEREDU / Cusco - 2022',
    'service' => 'μservicio para la gestión del ÁREA CURRICULAR',
    'version' => 'v' . VERSION,
  ]);
}, 'GET');

# -----------------------------------------------------------------------------------------------------------------
Route::pathNotFound(function($path)
{
  echo '<h1>Error 404 - ["' . $path . '"]<br /> URL/Página no encontrada</h1>';
});

#  ----------------------------------------------------------------------------------------------------------------- 
Route::run('/', true, true);
