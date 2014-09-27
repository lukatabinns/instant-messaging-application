				
<?php
	/*This will display the users registered on the system within the user area. 
	*The idea is to show various status such as "online", "is typing" and "last seen".
	*/
	
	/*if(($userid = $user->filter->userid) && ($userid > 1)){
	$result1 = $db->query("SELECT * FROM `".MLS_PREFIX."users` WHERE `userid` != $userid ORDER by `userid` ASC ");
	while($extract = mysqli_fetch_array($result1)){
		if (!empty($extract['username'])){
		echo           "<div class=\"users-wrapper\">";
		echo	      		" <div class=\"users-list\"> ";
		echo					" <ul class =\"users-holder-ul\"> ";
		echo						" <li class=\"users-holder\" > ";
		echo							"<span class=' '> " . "<img src='".$user->getAvatar()."' width='18' class='img-polaroidms' >" . " </span><a href=\"profile.php?u=?1\" class= \"proname\"><span class = 'uname'> " . $extract['username'] . "</span></a></br>";
		echo						"</li>";
		echo					"</ul>";
		if($username = $user->filter->username){
		echo                    "<div id =\"notify\">";
		echo                    "</div>";
		}
		echo				"</div>";
		echo			"</div>";

		}else return false;
	}
}*/

include_once 'lib/pagination.class.php';

include_once "inc/init.php";

$content = ''; // will store the html code for users list

if(!isset($_GET['page']))
  $page_number = 1;


$sort_name = array("id", "name");

// sorting
if(!isset($_GET['sort']) || !in_array($_GET['sort'], array(0,1)))  // check if it's a valid sort option
  $sort = 0;
else
  $sort = (int)$_GET['sort'];

if(!isset($_GET['sort_type']) || !in_array($_GET['sort_type'], array(0,1)))
  $sort_type = 0;
else
  $sort_type = (int)$_GET['sort_type'];


if($sort == 1) {
  $order_by = "`username` ". (!$sort_type ? "ASC" : "DESC");
} else {
  $order_by = "`userid` ". (!$sort_type ? "ASC" : "DESC");
}

$show_sort_options = '';
foreach ($sort_name as $k => $v) {
	if($k != $sort)
    $show_sort_options .= "<li><a href='?sort=$k'>Sort by $v</a></li>";
}



// search

$where = '';

if(isset($_GET['q'])) 
  $where = $db->parse("WHERE `username`  LIKE ?s", '%'.$_GET['q'].'%');
if($total_results = $db->getRow("SELECT COUNT(*) as count FROM `".MLS_PREFIX."users` ?p " , $where)->count ) {

    // pagination
    if(!isset($page_number))
      $page_number = (int)$_GET['page'] <= 0 ? 1 : (int)$_GET['page']; // grab the page number

    $perpage = 100; // number of elements perpage


    if($page_number > ceil($total_results/$perpage))
      $page_number = ceil($total_results/$perpage);


    $start = ($page_number - 1) * $perpage;
	
	if(($userid = $user->filter->userid)){
    $data = $db->getAll("SELECT * FROM `".MLS_PREFIX."users` WHERE `userid` != $userid ORDER BY  userid", $where, $order_by, $start, $perpage);
	
           	
    $pagination = new pagination($total_results, $page_number, $perpage);
	

    foreach($data as $u) {
			  $content .=  " <li class='users-holder'> 
				<a href='$set->url/profile.php?u=$u->userid'><img src='".$user->getAvatar($u->userid)."' width='80' class='img-polaroidms' alt='".$options->html($u->username)."' ></a>
				        
					  <span><a href='$set->url/profile.php?u=$u->userid' class = 'uname'>".$options->html($u->username)."</a></span><br>
					  <div id='stat'>".$options->tsince($u->lastactive)."</div><div id =\"notify\"></div><hr> 

			  </li>";
			 "<div class='verticalLine'>hello</div>";
			
    }
    
   }
} else
  $page->error = "No results were found !";



  if(isset($data))



if(isset($page->error))
  $options->error($page->error);
else if(isset($page->success))
  $options->success($page->success);


echo "
  <div class='users-wrapper'>
	 <div class='users-list'>
		<ul class='users-holder-ul'>
			$content
		</ul>
	</div>
  </div>
";