<?php
namespace Core;

use Helpers\Database;

/*
 * model - the base model
 *
 * @author David Carr - dave@simplemvcframework.com
 * @version 2.2
 * @date June 27, 2014
 * @date updated May 18 2015
 */

abstract class Model
{
    /**
     * hold the database connection
     * @var object
     */
    protected $db;

    /**
     * create a new instance of the database helper
     */
    public function __construct()
    {
        //connect to PDO here.
        $this->db = Database::get();

    }


    public function find($id){
        $prykey = $this->getKey();

        try{
            return $this->db->selectRow("SELECT * FROM `$this->table` WHERE $prykey = '$id' ");
            }   
        catch(Exception $e){
            return false;
        }
    }


    public function all(){
        try{
            return $this->db->select("SELECT * FROM `$this->table`");
            }
        catch(Exception $e){
            return false;
            }   
    }

    public function query($query){
        try{
            return $this->db->select($query);
            }
        catch(Exception $e){
            return false;
            }   
    }


    public function create($insert_array){
        try{

            $this->db->insert("`".$this->table."`",$insert_array);
            return $this->db->lastInsertId();

        }   catch(Exception $e){
            return false;
        }   

    }


    

    public function get($where_array = null){
            $i=0; foreach($where_array as $key => $value){
                if($i == 0)
                    $append = "WHERE ".$key." = '".$value."'";
                else
                    $append .= " AND ".$key." = '".$value."'";
            $i++;
            }

            try{
                return $this->db->select("SELECT * FROM `$this->table` $append");
                }
            catch(Exception $e){
                return false;
                }   
    }

    public function getRow($where_array = null){            
            $i=0; foreach($where_array as $key => $value){
                if($i == 0)
                    $append = "WHERE ".$key." = '".$value."'";
                else
                    $append .= " AND ".$key." = '".$value."'";
            $i++;
            }
            
            try{
                return $this->db->selectRow("SELECT * FROM `$this->table` $append");
                }
            catch(Exception $e){
                return false;
                }   
    }

    public function getCol($column, $value){
        try{
                return $this->db->select("SELECT * FROM `$this->table` WHERE $column = :value", 
                                array('value'=>$value));
            }  catch (Exception $e){
            return null;
        }
            
        
    }

    public function getColRow($column, $value){
        try{
                return $this->db->selectRow("SELECT * FROM `$this->table` WHERE $column = :value", 
                                array('value'=>$value));
            }  catch (Exception $e){
            return null;
        }
            
        
    }



    public function update($update_array,$where_array){
        try{
                return $this->db->update("`".$this->table."`",$update_array,$where_array);
            }
        catch(Exception $e){
            return false;
        }
    }

    public function updateId($update_array,$id){
        $prykey = $this->getKey();
        $where_array = array($prykey=>$id);
        try{
                return $this->db->update("`".$this->table."`",$update_array,$where_array);
            }
        catch(Exception $e){
            return false;
        }
    }


    public function groupByCol($column){
        try{
                return $this->db->select("SELECT * FROM `$this->table` GROUP BY $column");
            }
        catch(Exception $e){
            return false;
        }
    }


    


    public function delete($where_array){
        try{
            $this->db->delete("`".$this->table."`",$where_array);
            return $this->db->count;
            }
        catch(Exception $e){
            return false;
        }

    }

    public function deleteId($id){
        $prykey = $this->getKey();

        $where_array = array($prykey => $id);

        try{
            $this->db->delete("`".$this->table."`", $where_array);
            return $this->db->count;
            }
        catch(Exception $e){
            return false;
        }

    }


    public function truncate(){
        try{
            $this->db->truncate("`".$this->table."`");
            return $this->db->count;
            }
        catch(Exception $e){
            return false;
            }

    }

    public function getkey(){
        $row = $this->db->selectRow("SHOW INDEX FROM `$this->table` WHERE Key_name = 'PRIMARY'"); 

        return $row->Column_name;
    }

}

