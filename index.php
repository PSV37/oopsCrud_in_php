<?php
 session_start();
 class oops
 {
 	public function connection()
 	{
 		return mysqli_connect('localhost','root','','db_oops');
 	}

 	public function insert($sql)
 	{
 		$db = $this->connection();
 		return mysqli_query($db , $sql);
 	}

 	public function select($sql)
 	{
 		$db = $this->connection();
 		return mysqli_query($db , $sql);
 	}

 	public function delete($sql)
 	{
 		$db = $this->connection();
 		return mysqli_query($db,$sql);
 	}

 	public function update($sql)
 	{
 		$db = $this->connection();
 		return mysqli_query($db , $sql);
 	}
 }

 ?>

 <!DOCTYPE html>

 	<?php
  $obj = new oops();
 	 ?>
 <html>
 <head>
 	<title>
 		oops Crud
 	</title>
 	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 	 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap.min.css">
 </head>
 <body>
<?php

 if(isset($_GET['edit_id']))
	 {
		$edit_id = $_GET['edit_id'];
		$update = $obj->select("SELECT * FROM tbl_user WHERE id ='$edit_id' ") ;
		$updata = mysqli_fetch_array($update);
	 }	

  ?>
<div class="row">
   <h2 class="text-center">Basic CRUD Using OOPS</h2>
   <?php if(isset($_SESSION['msg'])): ?>
      <div class="alert alert-success alert-dismissable" style="width: 73%;margin-left: 16%;text-align: center;">
         <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
           <?php echo $_SESSION['msg'];
             unset($_SESSION['msg']);
            ?>
      </div>
   <?php endif ?>
	 <div class="col-md-6">

         <table id="example" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
               <thead>
                    <tr>
                         <th>Id</th>
				        <th>Name</th>
				        <th>Email</th>
				        <th>gender</th>
				        <th>Edit</th>
				        <th>Delete</th>
                    </tr>
                </thead>
                    <tbody>
                       <?php
			                 $sel = $obj->select("SELECT * FROM tbl_user");
			                 while($data = mysqli_fetch_array($sel))
			                 {
				    	 ?>
					      <tr>
					        <td><?php echo $data['id']; ?></td>
					        <td><?php echo $data['name']; ?></td>
					        <td><?php echo $data['email']; ?></td>
					        <td><?php echo $data['gender']; ?></td>
					        <td><a href="index.php?edit_id=<?php echo $data['id']; ?>" class="btn btn-info">Edit</td>
					        <td><a href="index.php?del_id=<?php echo $data['id']; ?>" class="btn btn-danger" onclick="return confirm('Are You Sure....')">Delete</td>
					        	<input type="hidden" value="<?php echo $data['id'] ?>">
					      </tr>
					    <?php } ?>
                </tbody>
            </table>
        </div>


	 <div class="col-md-6">
	 	<div>
	 		<?php 
              if(isset($updata)){
	 		  ?>
	 		  <h3>Update User</h3>
	 		  <?php } else{ ?>
	 		  <h3>Add New User</h3>
	 		  <?php } ?>
	 	</div>
		<form class="form-horizontal" action="" method="post" style="margin-left: 8%">
			<div class="form-group">
				<label>Name</label>
				<input type="text" name="name" class="form-control" placeholder="Name" value="<?php echo isset($updata) && $updata['name']!='' ? $updata['name'] : '' ?>">
				<input type="hidden" name="id" value="<?php echo isset($updata) && $updata['id']!="" ? $updata['id']:'';?>">
			</div>
			<div class="form-group">
				<label>Email</label>
				<input type="email" name="email"   class="form-control" placeholder="Email" value="<?php echo isset($updata) && $updata['email']!='' ? $updata['email'] : '' ?>">
			</div>
			<div class="form-group">
				<label>gender</label>
				<select name="gender" class="form-control">
					<option value="">select gender</option>
					<option value="male" <?php echo isset($updata) && $updata['gender'] =='male' ?'selected' :'' ?> >Male</option>
					<option value="female" <?php echo isset($updata) && $updata['gender'] =='female' ?'selected' :'' ?> >Female</option>
				</select>
			</div>
			<div class="form-group">
				<?php 
	              if(isset($updata)){
		 		  ?>
		 		<input type="submit"  name="update" class="btn btn-primary" value="update">
		 		  <?php } else{ ?>
		 		<input type="submit"  name="submit" class="btn btn-primary" value="Create">
		 		  <?php } ?>
				   
			    <?php if(isset($updata)){ ?>
			     <a href="index.php" class="btn btn-success">Create New</a>
			     <?php } ?>
			</div>
		</form>
	 </div>
</div>

<?php

 if(isset($_POST['submit']))
{
  $name = $_POST['name'];
  $email = $_POST['email'];
  $gender = $_POST['gender'];
   $obj->insert("INSERT INTO tbl_user (name , email , gender) VALUES ('$name','$email','$gender')");
   $_SESSION['msg'] = 'User Added Successfully ';
   header('location:index.php');
}

 if(isset($_POST['update']))
{
  $id = $_POST['id'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $gender = $_POST['gender'];
 $obj->update("UPDATE  tbl_user SET  name ='$name' , email ='$email',gender='$gender' WHERE id ='$id' ");
   $_SESSION['msg'] = 'User updated Successfully ';
   header('location:index.php');
}

if(isset($_GET['del_id']))
{
	$del_id = $_GET['del_id'];
	$obj->delete("DELETE FROM tbl_user WHERE id ='$del_id' ");
	 $_SESSION['msg'] = 'User Deleted Successfully ';
	  header("Location:index.php");
}
?>










<script
  src="https://code.jquery.com/jquery-3.3.0.min.js"
  integrity="sha256-RTQy8VOmNlT6b2PIRur37p6JEBZUE7o8wPgMvu18MC4="
  crossorigin="anonymous"></script>
 <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#example').DataTable();
            
          });
       
    </script>

</body>
</html>
