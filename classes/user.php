<?php 
class user extends mysqlManager
{
	public  $userdata;
	public	$roles;
	public	$menus;
	
	function __construct($id_user)
	{
		
		$where = Array('id_user' => $id_user);
		$columns = Array('id_company',
						 'company_name',
						'id_user',
						'username',
						'mail',
						'name',
						'description',
						'image',
						'phone',
						'cellphone',
						'status',
						'created_date',
						'created_by',
						'updated_date',
						'updated_by');
						
						
		$query = $this->selectRecord('v_usr_user',$columns,$where);
		$this->userdata = $query->data[0];
	}
	
	public function get_user_roles()
	{
		$where = Array('id_user' => $this->userdata->id_user);
		$columns = Array('id_role','role');
		$query = $this->selectRecord('v_user_role',$columns,$where);
		$this->roles = $query->data[0];
		return $this->roles;
	}
	
	public function get_user_menus()
	{
		if(empty($this->roles))
		{
			$this->get_user_roles();
		}
		$where = Array('id_role' => $this->roles->id_role);
		$columns = Array('id_menu','menu');
		$query = $this->selectRecord('v_role_menu',$columns, $where);
		$this->menus = $query->data;
		return $this->menus;
	}
	
	
}

?>