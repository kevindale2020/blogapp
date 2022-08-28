<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = 'CakePHP: the rapid development php framework';

?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->meta("myToken", $this->request->getAttribute("csrfToken")) ?>

    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">

    <?= $this->Html->css('https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand" href="#">Blog App</a>

  <!-- Links -->
  <ul class="navbar-nav">
    <?php if($loggedIn): ?>
    <li class="nav-item">
       <?= $this->Html->link('Home', '/user', ['class' => 'nav-link']); ?>
    </li>
    <li class="nav-item">
      <?= $this->Html->link('Contacts', '/user/contact', ['class' => 'nav-link']); ?>
    </li>
    <?php if($isAdmin): ?>
    <li class="nav-item">
      <?= $this->Html->link('Users', '/user/test', ['class' => 'nav-link']); ?>
    </li>
  <?php endif; ?>
     <li class="nav-item">
      <?= $this->Html->link('Logout', '/logout', ['class' => 'nav-link']); ?>
    </li>
  <?php else: ?>
    <li class="nav-item">
       <?= $this->Html->link('Home', '/', ['class' => 'nav-link']); ?>
    </li>
    <li class="nav-item">
      <?= $this->Html->link('Register', '/register', ['class' => 'nav-link']); ?>
    </li>
    <li class="nav-item">
      <?= $this->Html->link('Login', '/login', ['class' => 'nav-link']); ?>
    </li>
  <?php endif; ?>

    <!-- Dropdown -->
    <!-- <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        Dropdown link
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="#">Link 1</a>
        <a class="dropdown-item" href="#">Link 2</a>
        <a class="dropdown-item" href="#">Link 3</a>
      </div>
    </li> -->
  </ul>
</nav>
<br>
<div class="container">
  <?= $this->fetch('content') ?>
</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!--     <?= $this->Html->script('https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js') ?> -->
    <?= $this->Html->script('https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js') ?>
    <?= $this->Html->script('https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js') ?>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="myToken"]').attr('content')
            }
        });
    </script>
    <script type="text/javascript">
      
      $(document).ready(function(){

        getUsers();

        getPosts();

        // register function
        $('#regForm').submit(function(e){

          e.preventDefault();

          var email = $('#email').val();
          var pass1 = $('#pass1').val();
          var pass2 = $('#pass2').val();

          var message = "";

          if(email==''||pass1==''||pass2=='') {

            if(email=='') {

              message += "Email is required\n";
            }

            if(pass1=='') {

              message += "Password is required\n";
            }

             if(pass2=='') {

              message += "Confirm password is required\n";
            }

            alert(message);

            return false;
          }

          if(pass1!=pass2) {

            message += "Password does not match";

            alert(message);

            return false;
          }

          if(pass1.length < 8) {

            message += "Password should at least be 8 characters";

            alert(message);

            return false;

          }

          $.ajax({

            url: '<?=$this->Url->build('/register')?>',
            method: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(data) {

              if(data.success==1) {
                alert('You are now registered');;;
              }
            },
            error: function(jqXHR, status, error) {
              console.log(status);
              console.log(error);
            }
          });
        });

        // login function
        $('#loginForm').submit(function(e){

          e.preventDefault();

          var email = $('#email').val();
          var password = $('#password').val();

          var message = "";

          if(email==''||password=='') {

            if(email=='') {

              message += "Email is required\n";
            }

            if(password=='') {

              message += "Password is required\n";
            }

            alert(message);

            return false;
          }

          $.ajax({

            url: '<?=$this->Url->build('/login')?>',
            method: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(data) {

              if(data.success==1) {
                window.location.href='<?=$this->Url->build('/user')?>';
              } else {
                alert('Invalid credentials');
              }
            },
            error: function(jqXHR, status, error) {
              console.log(status);
              console.log(error);
            }
          });
        });

        // preview selected
        $(document).on('click', '.edit_user', function(){

          var id = $(this).attr('data-id');
          var fname = $(this).attr('data-fname');
          var lname = $(this).attr('data-lname');
          var address = $(this).attr('data-address');
          var email = $(this).attr('data-email');
          var phone = $(this).attr('data-phone');

          $('#userid').val(id);
          $('#fname').val(fname);
          $('#lname').val(lname);
          $('#address').val(address);
          $('#email').val(email);
          $('#phone').val(phone);

          $('#editUserModal').modal('show');
        });

        // edit user
         $('#editUserForm').submit(function(e){

          e.preventDefault();

          var email = $('#email').val();
          var fname = $('#fname').val();
          var lname = $('#lname').val();
          var address = $('#address').val();
          var phone = $('#phone').val();

          var message = "";

          if(email==''||fname==''||lname==''||address==''||phone=='') {

            if(email=='') {

              message += "Email is required\n";
            }

            if(phone=='') {

              message += "Phone is required\n";
            }

            if(fname=='') {

              message += "First name is required\n";
            }

            if(lname=='') {

              message += "Last name is required\n";
            }

            if(address=='') {

              message += "Address is required\n";
            }

            alert(message);

            return false;
          }

          $.ajax({

            url: '<?=$this->Url->build('/user/edit')?>',
            method: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(data) {

              if(data.success==1) {
                alert('Successfully saved');
                $('#editUserForm')[0].reset();
                $('#editUserModal').modal('hide');
                getUsers();
              }
            },
            error: function(jqXHR, status, error) {
              console.log(status);
              console.log(error);
            }
          });
        });

         // add new post
         $('#postForm').submit(function(e){

          e.preventDefault();

          var extension = $('#image').val().split('.').pop().toLowerCase();
          var title = $('#title').val();
          var body = $('#body').val();

          var message = '';

          if(title==''||body=='') {

            if(title=='') {
              message += 'Title field required\n';
            }

            if(body=='') {
              message += 'Body field required\n';
            }

            alert(message);

            return false;
          }

          if(image!='') {

                if(jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {

                    alert('Invalid File');

                    return false;
                }
          }

          $.ajax({

            url: '<?=$this->Url->build('/user')?>',
            method: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(data) {
              alert(data.message);
              $('#postForm')[0].reset();
              $('#postModal').modal('hide');
              getPosts();
            },
            error: function(jqXHR, status, error) {
              console.log(status);
              console.log(error);
            }
          });
         });

         $(document).on('click', '.delete_user', function(){

            var id = $(this).attr('data-id');

            if(confirm('Are you sure you want to delete this contact?')) {

              $.ajax({

                url: '<?=$this->Url->build('/user/delete')?>',
                method: 'POST',
                async: false,
                data: {
                  id: id
                },
                success: function(data) {
                  if(data.success==1) {
                    alert(data.message);
                    getUsers();
                  }
                },
                error: function(jqXHR, status, error) {
                  console.log(status);
                  console.log(error);
                }
              });
            } else {

              return false;
            }

         });
      });

      function getUsers() {

        $.ajax({

          url: '<?=$this->Url->build('/user/test')?>',
          method: 'POST',
          async: false,
          data: {
            fetch_user: 1
          },
          success: function(data) {
            console.log(data);
            $('#users').html(data.users);
          }
        });
      }

       function getPosts() {

        $.ajax({

          url: '<?=$this->Url->build('/user')?>',
          method: 'POST',
          async: false,
          data: {
            fetch_posts: 1
          },
          success: function(data) {
            console.log(data);
            if(data.success==1) {
                 $('#posts').html(data.posts);
            }
          }
        });
      }
    </script>
</body>
</html>
