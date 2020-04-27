<?php

//test_api.php

include('Api.php');

$api_object = new API();

if($_GET["action"] == 'fetch_all')
{
	$data = $api_object->fetch_all($_GET["id"]);
}
if($_GET["action"] == 'insert')
{
	$data = $api_object->insert();
}
if($_GET["action"] == 'insert_fb_user')
{
	$data = $api_object->insert_fb_user();
}
if($_GET["action"] == 'insert_message')
{
	$data = $api_object->insert_message();
}
if($_GET["action"] == 'insert_liked')
{
	$data = $api_object->insert_liked();
}
if($_GET["action"] == 'register_number')
{
	$data = $api_object->register_number();
}
if($_GET["action"] == 'fetch_single')
{
	$data = $api_object->fetch_single($_GET["id"]);
}
if($_GET["action"] == 'fetch_phonenumber')
{
	$data = $api_object->fetch_phonenumber($_GET["number"]);
}
if($_GET["action"] == 'checkCode')
{
	$data = $api_object->checkCode($_GET["number"]);
}
if($_GET["action"] == 'fetch_likeexists')
{
	$data = $api_object->fetch_likeexists($_GET["userparam"]);
}
if($_GET["action"] == 'fetch_userexists')
{
	$data = $api_object->fetch_userexists($_GET["email"]);
}
if($_GET["action"] == 'fetch_search_reference')
{
	$data = $api_object->fetch_search_reference($_GET["id"]);
}
if($_GET["action"] == 'fetch_userimage')
{
	$data = $api_object->fetch_userimage($_GET["id"]);
}
if($_GET["action"] == 'fetch_message')
{
	$data = $api_object->fetch_message($_GET["user_id"]);
}
if($_GET["action"] == 'fetch_gallery')
{
	$data = $api_object->fetch_gallery($_GET["user_id"]);
}
if($_GET["action"] == 'fetch_inbox')
{
	$data = $api_object->fetch_inbox($_GET["id"]);
}
if($_GET["action"] == 'fetch_recentmatches')
{
	$data = $api_object->fetch_recentmatches($_GET["id"]);
}
if($_GET["action"] == 'update')
{
	$data = $api_object->update();
}
if($_GET["action"] == 'updateUser')
{
	$data = $api_object->updateUser();
}
if($_GET["action"] == 'updateVisible')
{
	$data = $api_object->updateVisible();
}
if($_GET["action"] == 'update_search_reference')
{
	$data = $api_object->update_search_reference();
}
if($_GET["action"] == 'delete')
{
	$data = $api_object->delete($_GET["id"]);
}
if($_GET["action"] == 'insert_gallery')
{
	$data = $api_object->insert_gallery();
}

echo json_encode($data);

?>