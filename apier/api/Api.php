<?php

//Api.php

class API
{
	private $connect = '';

	function __construct()
	{
		$this->database_connection();
	}

	function database_connection()
	{
		$this->connect = new PDO("mysql:host=localhost;dbname=chatter", "root", "");
	}

	function fetch_all($id)
	{
		$query = "SELECT image, id, username, location FROM tbl_user where id not in(SELECT case when user_id = '".$id."' then user_id_liked else user_id end from tbl_liked where (user_id = '".$id."' or user_id_liked = '".$id."') and visible = 1) and id <> '".$id."'
			union all 
			SELECT image, id, username, location FROM tbl_fbuser where id not in(SELECT case when user_id = '".$id."' then user_id_liked else user_id end from tbl_liked where (user_id = '".$id."' or user_id_liked = '".$id."') and visible = 1) and id <> '".$id."';
";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$data[] = $row;
			}
			return $data;
		}
	}
	function fetch_search_reference($id)
	{

		$query = "SELECT * FROM search_reference where user_id='".$id."'";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$data[] = $row;
			}
			return $data;
		}
	}
	function checkCode($number)
	{
		$query = "SELECT * FROM tbl_registered_number where phone_number='".$number."'";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$data[] = $row;
			}
			return $data;
		}
	}

	function insert()
	{
		if(isset($_POST["email"]))
		{
			$form_data = array(
				':email'		=>	$_POST["email"],
				':password'		=>	$_POST["password"],
				':username'		=>	$_POST["username"],
				':gender'		=>	$_POST["gender"],
				':image'        => 	$_POST["image"],
				':location'     => 	$_POST["location"],
				':phone_number' => 	$_POST["phone_number"]
			);
			$query = "
			INSERT INTO tbl_user 
			(email, password,username,gender,image,location,phone_number) VALUES 
			(:email, :password,:username,:gender,:image,:location,:phone_number)
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = array(
					'success'	=>	'1'
				);
			}
			else
			{
				$data[] = array(
					'success'	=>	'02'
				);
			}
		}
		else
		{
			$data[] = array(
				'success'	=>	'03'
			);
		}
		return $data;
	}
	function register_number()
	{
		if(isset($_POST["phone_number"]))
		{
			$form_data = array(
				':phone_number'		=>	$_POST["phone_number"],
				':code'		=>	$_POST["code"]
			);
			$query = "
			REPLACE INTO tbl_registered_number set phone_number = :phone_number, code = :code
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = array(
					'success'	=>	'1'
				);
			}
			else
			{
				$data[] = array(
					'success'	=>	'02'
				);
			}
		}
		else
		{
			$data[] = array(
				'success'	=>	'03'
			);
		}
		return $data;
	}
	function insert_fb_user()
	{
		if(isset($_POST["id"]))
		{
			$form_data = array(
				':id'		=>	$_POST["id"],
				':email'		=>	$_POST["email"],
				':password'		=>	$_POST["password"],
				':username'		=>	$_POST["username"],
				':gender'		=>	$_POST["gender"],
				':image'        => 	$_POST["image"],
				':location'     => 	$_POST["location"]
			);
			$query = "
			INSERT INTO tbl_fbuser 
			(id,email, password,username,gender,image,location) VALUES 
			(:id,:email, :password,:username,:gender,:image,:location)
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = array(
					'success'	=>	'1'
				);
			}
			else
			{
				$data[] = array(
					'success'	=>	'02'
				);
			}
		}
		else
		{
			$data[] = array(
				'success'	=>	'03'
			);
		}
		return $data;
	}
	function insert_message()
	{
		if(isset($_POST["message"]))
		{
			$form_data = array(
				':session_id'		=>	$_POST["session_id"],
				':sender_id'		=>	$_POST["sender_id"],
				':receiver_id'		=>	$_POST["receiver_id"],
				':sender_username'	=>	$_POST["sender_username"],
				':message'			=>	$_POST["message"]
			);
			$query = "
			INSERT INTO tbl_conversation 
			(sender_id,sender_username,message,session_id,receiver_id) VALUES 
			(:sender_id,:sender_username,:message,:session_id,:receiver_id)
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = $form_data;
			}
			else
			{
				$data[] = array(
					'success'	=>	'02'
				);
			}
		}
		else
		{
			$data[] = array(
				'success'	=>	'03'
			);
		}
		return $data;
	}
	function insert_liked()
	{
		if(isset($_POST["user_id"]))
		{
			$form_data = array(
				':user_id'		=>	$_POST["user_id"],
				':user_id_liked'	=>	$_POST["user_id_liked"],
				':visible'			=>	$_POST["visible"]
					
			);
			$query = "
			INSERT INTO tbl_liked 
			(user_id,user_id_liked,visible) VALUES 
			(:user_id,:user_id_liked,:visible)
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = $form_data;
			}
			else
			{
				$data[] = array(
					'success'	=>	'02'
				);
			}
		}
		else
		{
			$data[] = array(
				'success'	=>	'03'
			);
		}
		return $data;
	}
	function insert_gallery()
	{
		if(isset($_POST["user_id"]))
		{
			$form_data = array(
				':user_id'		=>	$_POST["user_id"],
				':is_dp'	=>	$_POST["is_dp"],
				':image'			=>	$_POST["image"]
					
			);
			$query = "
			INSERT INTO tbl_gallery  
			(user_id,is_dp,image) VALUES 
			(:user_id,:is_dp,:image)
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = $form_data;
			}
			else
			{
				$data[] = array(
					'success'	=>	'02'
				);
			}
		}
		else
		{
			$data[] = array(
				'success'	=>	'03'
			);
		}
		return $data;
	}


	function fetch_single($id)
	{
		$query = "SELECT username FROM tbl_user WHERE id='".$id."'";
		$statement = $this->connect->prepare($query);
		$returnValue;
		if($statement->execute())
		{
			foreach($statement->fetchAll() as $row)
			{
				$returnValue = $row[0];
			}
			return $returnValue;
		}
	}
	function fetch_message($user_id)
	{
		$var = explode(",",$user_id);
		$query = "SELECT id,session_id,sender_id,receiver_id,sender_username,message,`datetime` FROM tbl_conversation WHERE (sender_id='".str_replace("'","",$var[0])."' and receiver_id='".str_replace("'","",$var[1])."') or (sender_id='".str_replace("'","",$var[1])."' and receiver_id='".str_replace("'","",$var[0])."') order by datetime"; 
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$data[] = $row;
			}
			return $data;
		}
	}
	function fetch_gallery($user_id)
	{
		$query = "SELECT * from tbl_gallery where user_id ='".$user_id."'";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$data[] = $row;
			}
			return $data;
		}
	}

	function fetch_inbox($id)
	{
		$query = "SELECT c.id `session_id`,a.id `user_id`,a.username,group_concat(message order by b.datetime desc limit 1) `message`,group_concat(b.datetime order by b.datetime desc limit 1) `datetime`,a.image from (select * from tbl_user union all select * from tbl_fbuser) a left join tbl_conversation b on b.sender_id = a.id left join tbl_liked c on c.user_id = a.id or user_id_liked = a.id where 
					a.id in (SELECT CASE WHEN user_id ='".$id."' then user_id_liked else user_id end FROM tbl_liked where (user_id = '".$id."' or user_id_liked ='".$id."') and visible = 1)  
					group by username order by b.datetime;";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$data[] = $row;
			}
			return $data;
		}
	}
	function fetch_recentmatches($id)
	{
		$query = "SELECT 
				    user_id, b.username, b.image, datetime
				FROM
				    (SELECT 
				        IF(user_id = '".$id."', user_id_liked, user_id) `user_id`, datetime
				    FROM
				        chatter.tbl_liked
				    WHERE
				        visible = 1
				            AND (user_id = '".$id."' OR user_id_liked = '".$id."')) a
				        LEFT JOIN
				    (SELECT id,image,username from tbl_user union all select id,image,username from tbl_fbuser) b ON a.user_id = b.id
				ORDER BY datetime DESC limit 7";

		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$data[] = $row;
			}
			return $data;
		}
	}
	function fetch_userexists($email)
	{
		$var = explode(",",$email);
		$query = "SELECT * FROM tbl_user WHERE email='".str_replace("'","",$var[0])."' and password='".str_replace("'","",$var[1])."' and phone_number=''";
		$statement = $this->connect->prepare($query);
		$returnValue;
		if($statement->execute())
		{
			while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$data[] = $row;
			}
			return $data;
		}
	}
	function fetch_phonenumber($number)
	{
		$query = "SELECT * FROM tbl_user WHERE phone_number='".$number."'";
		$statement = $this->connect->prepare($query);
		$returnValue;
		if($statement->execute())
		{
			while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$data[] = $row;
			}
			return $data;
		}
	}
	function fetch_likeexists($userparam)
	{
		$var = explode(",",$userparam);
		$query = "SELECT id FROM tbl_liked WHERE (user_id='".str_replace("'","",$var[0])."' and user_id_liked='".str_replace("'","",$var[1])."') or (user_id='".str_replace("'","",$var[1])."' and user_id_liked='".str_replace("'","",$var[0])."')";
		$statement = $this->connect->prepare($query);
		$returnValue;
		if($statement->execute())
		{
			foreach($statement->fetchAll() as $row)
			{
				$returnValue = $row[0];
			}
			return $returnValue;
		}
	}

	function fetch_userimage($id)
	{
		$query = "SELECT image FROM tbl_user WHERE id='".$id."'";
		$statement = $this->connect->prepare($query);
		$returnValue;
		if($statement->execute())
		{
			foreach($statement->fetchAll() as $row)
			{
				$returnValue = $row[0];
			}
			return $returnValue;
		}
	}

	function update_search_reference()
	{
		if(isset($_POST["user_id"]))
		{
			$form_data = array(
				':user_id'	=>	$_POST['user_id'],
				':maximum_distance'	=>	$_POST['maximum_distance'],
				':age_range'			=>	$_POST['age_range']
			);
			$query = "REPLACE INTO search_reference SET user_id = :user_id, maximum_distance = :maximum_distance,age_range = :age_range;";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = array(
					'success'	=>	'1'
				);
			}
			else
			{
				$data[] = array(
					'success'	=>	'0'
				);
			}
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
		return $data;
	}
	function updateVisible()
	{
		if(isset($_POST["id"]))
		{
			$form_data = array(
				':visible'	=>	$_POST['visible'],
				':id'	=>	$_POST['id']
			);
			$query = "
			UPDATE tbl_liked 
			SET visible = :visible
			WHERE id = :id
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = array(
					'success'	=>	'1'
				);
			}
			else
			{
				$data[] = array(
					'success'	=>	'0'
				);
			}
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
		return $data;
	}
	function updateUser()
	{
		if(isset($_POST["id"]))
		{
			$form_data = array(
				':id'	=>	$_POST['id'],
				':about'	=>	$_POST['about'],
				':job_title'	=>	$_POST['job_title'],
				':company'	=>	$_POST['company'],
				':school'	=>	$_POST['school'],
				':city'	=>	$_POST['city'],
				':show_age'	=>	$_POST['show_age'],
				':show_distance'	=>	$_POST['show_distance']
			);
			$query = "UPDATE tbl_user 
			SET about = :about,job_title = :job_title,company = :company,school = :school,city = :city,show_age=:show_age,show_distance = :show_distance 
			WHERE id = :id
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = array(
					'success'	=>	'1'
				);
			}
			else
			{
				$data[] = array(
					'success'	=>	'0'
				);
			}
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
		return $data;
	}
	function delete($id)
	{
		$query = "DELETE FROM tbl_sample WHERE id = '".$id."'";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			$data[] = array(
				'success'	=>	'1'
			);
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
					$b64image = base64_encode(file_get_contents('https://firebasestorage.googleapis.com/v0/b/chatter-7b8e4.appspot.com/o/UserImages%2Fkentmjc02%40gmailcom.jpg?alt=media&token=009a47c8-acbc-4ec2-afa5-5d6828c7d8c5'));
			return $b64image;
		return $b64image;
	}
}

?>