<h1>index</h1>
<?php if(isset($articles) && !empty($articles)){ ?>
<table class="table">
  <thead>
    <tr>
      <th>Title</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($articles as $article) { ?>
    <tr>
      <td><?=$article['title'];?></td>
      <td><?=$article['description'];?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
<?php }else { ?>
<p>There are no articles</p>
<?php } ?>