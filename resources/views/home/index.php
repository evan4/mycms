<h1>index</h1>
<?php if(isset($users)){ ?>
<table class="table">
  <thead>
    <tr>
      <th>Username</th>
      <th>Email</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($users as $user) { ?>
    <tr>
      <td><?=$user['username'];?></td>
      <td><?=$user['email'];?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<?php }else { ?>
<p>There are no records in db</p>
<?php } ?>