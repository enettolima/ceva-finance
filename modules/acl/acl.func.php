<?

function view_levels()
{
  $acl = new Acl_Levels();
  $acl->load_list("ASSOC", "level <= '{$_SESSION['log_access_level']}'");
  for($i=0; $i<$acl->affected; $i++)
  {
    $line .= "<tr>
        <td>{$acl->data[$i]['level']}</td>
        <td>{$acl->data[$i]['description']}</td>
      </tr>"; 
  }
  $resp = "<br><table>
      <tr>
        <td><b>Level</b></td>
        <td><b>Description</b></td>
      </tr>
      {$line}
    </table>";

  return $resp;

}

function view_access_levels()
{
  $acl = new Acl_Levels();
  $acl->load_list("ASSOC", "level <= '{$_SESSION['log_access_level']}' ORDER BY level DESC");
  $total = 0;
  for($i=0; $i<$acl->affected; $i++)
  {
    $line .= "<tr>
        <td><input type='text' id='level_{$i}' name='level_{$i}' maxlength='2' size='3' value='{$acl->data[$i]['level']}'></td>
        <td><input type='text' name='desc_{$i}' id='desc_{$i}' value='{$acl->data[$i]['description']}'></td>
        <td><img onmouseover=\"this.style.cursor='pointer';\" onmouseout=\"this.className='';\" src='media/images/delete-16x16.gif' onclick=\"proccess_information('listacl', 'delete_acl_level', 'acl', 'Are you sure you want to delete this level?','level_id|{$acl->data[$i]['id']}');\"><input type='hidden' id='id_{$i}' value='{$acl->data[$i]['id']}' name='id_{$i}'></td>
      </tr>"; 
    $total++;
  }
  $resp = "
    <div class='hive-table'>
    <form id='listacl' name='listacl' action=\"javascript:proccess_information('listacl', 'update_acl_levels', 'acl', 'Are you sure you want to update these levels?');\">
      <table cellspacing='0' cellpadding='0' border='0' width='100%'>
        <thead>
          <tr>
            <th nowrap=''><b>Level</b></th>
            <th nowrap=''><b>Description</b></th>
            <th nowrap=''><b>Delete</b></th>
          </tr>
        </thead>
        <tbody>
          {$line}
          <tr>
            <td colspan='3'><input type='submit' value='Update'> <input type='button' value='Add New' onclick=\"proccess_information('listmainmenu', 'add_new_level', 'acl', '');\"><input type='hidden' value='{$total}' name='total' id='total'></td>
          </tr>
        </tbody>
      </table>
    </form>
    </div>";

  return $resp;

}

function update_acl_levels($data)
{
  for($i=0; $i<$data['total']; $i++)
  {
    $acl              = new Acl_levels();
    $acl->level       = $data['level_'.$i];
    $acl->description = strtolower($data['desc_'.$i]);
    $acl->update("id='{$data['id_'.$i]}'");

  }
  echo ACL_LEVELUPDATED_MESG; 
}

function add_new_level()
{
  $acl = new Acl_levelsTable();
  echo $acl->show_new();
}

function save_new_level($data)
{
  $acl = new Acl_levels();
  $acl->load_single("level='{$data['level']}' OR description='{$data['description']}'");
  if($acl->affected)
  {
    echo "ERROR|".ACL_LEVELDUPLICATED_CODE."|".ACL_LEVELDUPLICATED_MESG;
  }else{
    if(is_numeric($data['level']))
    {
      $acl->level       = $data['level'];
      $acl->description = strtolower($data['description']);
      $acl->insert();
      echo ACL_LEVELCREATED_MESG; 
    }else{
      echo "ERROR|".ACL_INVALIDLEVEL_CODE."|".ACL_INVALIDLEVEL_MESG; 
    }
  }
}

function delete_acl_level($data)
{
  $acl = new Acl_levels();
  $acl->load_single("id='{$data['level_id']}'");
  $user = new User();
  $user->load_list("ASSOC","access_level='{$acl->level}'");
  if($user->affected)
  {
    echo "ERROR|".ACL_INUSE_CODE."|".ACL_INUSE_MESG; 
  }else{
    $acl->remove("id='{$data['level_id']}'"); 
    if($acl->affected)
    {
      echo ACL_REMOVEOK_MESG;
    }else{
      echo "ERROR|".ACL_REMOVEERROR_CODE."|".ACL_REMOVEERROR_MESG; 
    }
  }

}

function find_initial_function()
{
  $menus = new DataManager();
  $menus->dm_load_single(NATURAL_DBNAME.".side_menu","initial='1'"); 
  return $menus->function; 
}

function execute_initial_function($init)
{

  /*switch($init)
  {
    case "view_my_info":
      
      $user   = new User(); 
      
      $user->load_single("username='{$_SESSION['log_username']}'"); 
      return $userfrm->show_edit($user);
      break;
  }*/
}

?>
