<div class="priser">
  
<script type="text/javascript">
    <?php 
        if (array_key_exists('loggedin', $_SESSION)){
            echo 'var loggedIn = '.json_encode($_SESSION['loggedin']).';';
        } else {
            echo 'var loggedIn = "nope";';
        }
    ?>
</script>
  
    
    

  
    
</div>
