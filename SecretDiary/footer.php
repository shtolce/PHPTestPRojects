        <script type="text/javascript">
                $('.toggleForms').click(function(){
                    $('#signUpForm').toggle();
                    $('#logInForm').toggle();
                });
                $('#diary').bind('input propertychange', function() {
                    
                    $.ajax({
                            method: "POST",
                            url: "updateDataBase.php",
                            data: { content:$("#diary").val() }
                            })
                
                });



            </script>


            <script src="https://code.jquery.com/jquery-3.3.1.min.js"  crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    </body>

</html>