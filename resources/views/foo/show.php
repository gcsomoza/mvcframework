<?php render('header'); ?>
  <h1>Foo</h1>
  <form method="post" action="<?php url('foo/save'); ?>">
    <input type="hidden" name="id" value="<?php echo $foo->id ?>" />
    <div class="form-group">
      <label>Name</label>
      <input type="text" name="name" value="<?php echo $foo->name ?>" />
    </div>
    <div class="form-group">
      <label>Address</label>
      <input type="text" name="address" value="<?php echo $foo->address ?>" />
    </div>
    <div>
      <button>Save</button>
      <a href="<?php echo url('foo') ?>">Return</a>
    </div>
  </form> 
<?php render('footer'); ?>