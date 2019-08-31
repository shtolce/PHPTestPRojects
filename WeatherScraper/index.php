<!doctype html>
<html lang="en">

<?php
  
  if (array_key_exists('city',$_GET))
    $city = str_replace(' ','',$_GET['city']);
  
  $weather="";
  $file = 'https://www.weather-forecast.com/locations/'.$city.'/forecasts/latest';
  $file_headers = @get_headers($file);
  if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
      $error = 'the city '.$city.'was not found. Try to fix capitals in the city name';
  }
  else {
    if ($city) {
      $forcastPage = file_get_contents('https://www.weather-forecast.com/locations/'.$city.'/forecasts/latest');
      $pageArray = explode('<span class="b-forecast__table-description-title"><h2>'.$_GET['city'].' Weather Today</h2> (1&ndash;3 days)</span>',$forcastPage);
      $secondPageArray = explode('</span></p></div><div class="location-summary__item location-summary__item--js is-truncated">', $pageArray[1]);
      if (sizeof($secondPageArray)>1)
        $weather =  $secondPageArray[1];
      else
        $error= "the city couldn't be found";

    }
  }
?>

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel='stylesheet' href = "./style.css"> 

    <title>The Weather Scraper</title>
  </head>
  <body>
    <div class="container">
      <h1>What is the weather</h1>

      <form>
      <p>Enter the name of a city</p>
      <div class="form-group">
        <label for="city">Email address</label>
        <input type="text" class="form-control" id="city" name="city" placeholder="e.g. London" value='<?php echo $_GET["city"] ?>'>
        <small class='text-muted'>We'll never share you email with anyone</small>
      </div>
      <button type='submit' class='btn btn-primary'>Submit</button>
      </form>
      <div id='weather'>
        <?php
          if ($weather) 
            echo '<div class="alert alert-success" role="alert">
            '.$weather.'
            </div>';
          else if ($error)
            echo '<div class="alert alert-danger" role="alert">
            '.$error.'
            </div>';


          
        ?>
      </div>



    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>