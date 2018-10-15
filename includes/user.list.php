		<?php
	echo "<h3>Add a new user</h3>";
	
	echo"	<table class=\"table table-dark\">
						  <thead>
						    <tr>
						      <th scope=\"Password\"></th>
						      <th scope=\"Name\">Name</th>
						      <th scope=\"Password\"></th>
						      <th scope=\"Surname\">Surname</th>
						      
						      <th scope=\"Email Address\">Email</th>
						      <th scope=\"Password\"></th>
						      <th scope=\"Group\">Group</th>
						      <th scope=\"Password\">Password</th>
						      <th scope=\"Password\"></th>
						      <th scope=\"Password\"></th>
						      <th scope=\"Password\"></th>
						      <th scope=\"Password\"></th>
						      <th scope=\"Password\"></th>
						      
						      <th scope=\"Password\"></th>
						      <th scope=\"Password\"></th>
						      <th scope=\"Password\"></th>
						      
						    </tr>
						  </thead>
						  </table>
						  ";
						  
		echo "<div class=\"row w-100\">
					<form id=\"user-form\" class=\"form-inline\" method=\"post\" action=\"user.manager.php\">";
					
			echo "
					<div class=\"form-group  mx-5\">
					  <input class=\"form-control\" type=\"text\" name=\"name\" id=\"name\" value=\"\"/>
					</div>
						  <div class=\"form-group mx-5\">
								  <input class=\"form-control\" type=\"text\" name=\"surname\" id=\"surname\" value=\"\" />
							  </div>
							  <div class=\"form-group \">
								  <input class=\"form-control\" type=\"email\" name=\"email\" id=\"email\" value=\"\"/>
							  </div>
							  <div class=\"form-group mx-5\">
									<select class=\"form-control custom-select\" name=\"group_id\" id=\"group_id\">
										<option value=\"\">Select a group</option>";
										foreach($groups as $item){
											$group_id = $item['group_id'];
											$group_name = $item['group_name'];
											echo "<option value=\"$group_id\">$group_name</option>";
										}
						echo"       </select>
							  </div>
							  <div class=\"form-group mx-5\">
								  <input class=\"form-control\" type=\"password\" name=\"password\" id=\"password\" placeholder=\"minimum 6 characters\"/>
							  </div>
							  <button id=\"action\" style = \"background-color:black;\" name=\"action\" value=\"add\" class=\"btn btn-info mt-3 mb-4 \" type=\"submit\">Add</button>
								</form>
							 </div>";
							 
							 echo "<h3> Change an existing user </h3>";
							 
							 echo"	<table class=\"table table-dark\">
						  <thead>
						    <tr>
						      <th scope=\"Name\">Name</th>
						      <th scope=\"Surname\">Surname</th>
						      <th scope=\"Email Address\">Email</th>
						      
						      <th scope=\"Password\"></th>
						      <th scope=\"Last login\">Login</th>
						      <th scope=\"Group\">Group</th>
						      <th scope=\"Password\">Password</th>
						      <th scope=\"Password\">Actions</th>
						      <th scope=\"Password\"></th>
						      <th scope=\"Password\"></th>
						    </tr>
						  </thead>
						  </table>
						  ";
							 
		if(count($users) >0){
			foreach($users as $item){
				$c_name = $item['name'];
				$c_surname = $item['surname'];
				$c_email = $item['email'];
				$c_last_login = $item['last_login'];
				$c_password = $item['password'];
				
			
						  
		   echo "<div class=\"row\">
					<form id=\"user-form\" class=\"form-inline\" method=\"post\" action=\"user.manager.php\">
					
					";
					
			echo "<div class=\"col form-group mx-auto\">
					</div>
					
					
					<input class=\"form-control\" type=\"text\" name=\"name\" id=\"name\" value=\"$c_name\"/>
						  <div class=\"form-group mx-4\">
							  
								  <input class=\"form-control\" type=\"text\" name=\"surname\" id=\"surname\" value=\"$c_surname\" />
							  </div>
							  <div class=\"form-group mx-4\">
								  
								  <input class=\"form-control\" type=\"email\" name=\"email\" id=\"email\" value=\"$c_email\"/>
							  </div>
							  <div class=\"form-group mx-4\">
								  
								  <input class=\"form-control\" type=\"text\" name=\"last_login\" id=\"last_login\" value=\"$c_last_login\" disabled=\"disabled\"/>
							  </div>
							  <div class=\"form-group mx-4\">
									
									<select class=\"form-control custom-select\" name=\"group_id\" id=\"group_id\">
										<option value=\"\">Select a group</option>";
										foreach($groups as $item){
												$group_id = $item['group_id'];
												$group_name = $item['group_name'];
												echo "<option value=\"$group_id\">$group_name</option>";
											}
						echo"       </select>
							  </div>
							  <div class=\"form-group mx-4\">
								  
								  <input class=\"form-control\" type=\"password\" name=\"password\" id=\"password\" placeholder=\"minimum 6 characters\"/>
							  </div>
							  
							  <button id=\"action\" style = \"background-color:black;\" name=\"action\" value=\"update_details\" class=\"btn btn-info mt-4 mb-4 mr-2\" type=\"submit\">Update Details</button>
							  <button id=\"action\" style = \"background-color:black;\" name=\"action\" value=\"update_password\" class=\"btn btn-info mt-4 mb-4  mr-2 \" type=\"submit\">Update Password</button>
							  <button id=\"action\" style = \"background-color:red;\" name=\"action\" value=\"delete\" class=\"btn btn-info mt-4 mb-4  mr-2 \" type=\"submit\">Delete</button>
							</form>
						</div>";
						
			}
			if(strlen($message) > 0){
							echo "<div class=\"row class=\"form-inline\"\">
									<div class=\"col-md-4 offset-md-4\">
										<div class=\"alert alert-$message_class alert-dismissable fade show\">
													$message
													<button class=\" close\"type=\"button\" data-dismiss=\"alert\">
														&times;
													</button>
										</div>
									</div>
								 </div>";
						}
		} else{
			echo "<div class=\"col-md-3\"> 
						<h4>No users found!</h4>
					</div>";
	}
?>