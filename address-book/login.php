<?php
require __DIR__ . "/parts/db-connect.php";
$title = '登入';
$pageName = 'login';
?>
<?php include __DIR__ . '/parts/html-head.php' ?>
<style>
  form .form-text {
    color: red;
  }
</style>
<?php include __DIR__ . '/parts/html-navbar.php' ?>
<div class="container">
  <div class="row">
    <div class="col-6">
      <div class="card">

        <div class="card-body">
          <h5 class="card-title">登入管理者</h5>
          <form name="loginForm" novalidate onsubmit="sendData(event)">
            <div class="mb-3">
              <label for="email" class="form-label">帳號</label>
              <input type="email" class="form-control" id="email" name="email" required>

            </div>
            <div class="mb-3">
              <label for="password" class="form-label">密碼</label>
              <input type="password" class="form-control" id="password" name="password">

            </div>

            <button type="submit" class="btn btn-primary">登入</button>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/parts/html-scripts.php' ?>
<script>
  function validateEmail(email) {
    const re =
      /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }

  const sendData = e => {
    e.preventDefault();

    const fd = new FormData(document.loginForm);

    fetch('login-api.php', {
        method: 'POST',
        body: fd
      })
      .then(r => r.json())
      .then(result => {
        console.log(result);
        if (result.success) {
          location.href = "list.php";
        } else {
          alert("帳號或密碼錯誤!!")
        }
      })
      .catch(ex => {
        console.warn('Fetch 出錯了!');
        console.warn(ex);
      })
  }
</script>
<?php include __DIR__ . '/parts/html-tail.php' ?>