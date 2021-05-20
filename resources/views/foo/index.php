<?php render('header'); ?>
  <h1>Foos</h1>
  <table>
    <?php foreach($foos as $foo): ?>
      <tr>
        <td><a href="<?php url("foo/{$foo->id}") ?>"><?php echo $foo->id ?></a></td>
        <td><?php echo $foo->name ?></td>
        <td><?php echo $foo->address ?></td>
        <td><a href="<?php url("foo/delete/{$foo->id}") ?>">Delete</a></td>
      </tr>
    <?php endforeach; ?>
  </table>
  <a href="<?php url('foo/new') ?>">Add new</a>
<?php render('footer'); ?>