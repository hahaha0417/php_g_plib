<?php

/*
 * 原始 : hahaha
 * 維護 : 
 * 指揮 : 
 * ---------------------------------------------------------------------------- 
 * 決定 : name
 * ----------------------------------------------------------------------------
 * 說明 : 
 * ----------------------------------------------------------------------------   
    
 * ----------------------------------------------------------------------------

*/

namespace g_plib\db\table;

/*
 --------------------------------------------------------------- 
輸出 - php 字串
 --------------------------------------------------------------- 
<?php

namespace xxx

class xxx
{
    const XXX = "xxx";
    const DDD = "ddd";
}
 --------------------------------------------------------------- 
*/

/*

*/
class hahaha_generate_php_const
{
	use \hahahalib\hahaha_instance_trait;
    
    public $Ip_;
    public $Port_;
	
    //-----------------------------------------------------------
    public function Initial()
    {
        $this->Ip_ = "127.0.0.1";
        $this->Port_ = "9000";

        return $this;
    }

    public function Initial_Setting(&$ip, &$port)
    {
        $this->Ip_ = &$ip;
        $this->Port_ = &$port;

        return $this;
    }

    //-----------------------------------------------------------
    public function Generate_Table(&$content, &$database, &$output_path, &$output_namespace = "", $doctrine_style = false, &$pass_tables = ["migrates"])
    {
        if(!is_dir($output_path)) 
        {
            mkdir($output_path, 0777, true);
        }

        $tables_ = preg_split('/\n|\r\n?\s*/', $content);

        foreach ($tables_ as $key => &$table) 
        {
            $table_name = trim($table);
            if (in_array($table, $pass_tables)) {
                unset($tables_[$key]);
            } 
            else if (empty($table_name)) {
                unset($tables_[$key]);
            }        
        } 

        $text = [];
        if($doctrine_style)
        {
            $name = str_replace(['_', '-'], [' ', ' '], $database);
            $name = ucwords($name);
            $name = str_replace([' ', '_', '-'], ['', '', ''], $name);
            
        }
        else
        {
            $name = $database;
        }
        
        $this->Generate_PHP_Const($text, $tables_, $output_namespace, $name); 
        // 寫檔
        $filename_ = $output_path . "/" . $name . ".php";
        $output_content_ = implode("\r\n", $text);
        file_put_contents($filename_ , $output_content_);
        
    }

    public function Generate_Table_Field(&$content, &$database, &$output_path, &$output_namespace = "", $doctrine_style = false, &$pass_tables = ["migrates"])
    {
        if(!is_dir($output_path)) 
        {
            mkdir($output_path, 0777, true);
        }

        $tables_ = preg_split('/\n|\r\n?\s*/', $content);

        foreach ($tables_ as $key => &$table) 
        {
            $table_name = trim($table);
            if (empty($table_name)) {
                continue;
            }

            // ---------------------------------------------------
            $db_hahaha = new \hahahalib\hahaha_db_mysql;
            $db_result_hahaha = new \hahahalib\hahaha_db_mysql_result;
            $db_hahaha->Connect("{$this->Ip_}:{$this->Port_}", "root", "hahaha", "{$database}");
            $db_hahaha->Set_Names("utf8");

            // 查資料表欄位
            $table_fields = [];
            $result = $db_hahaha->Query("SELECT * FROM information_schema.`COLUMNS` WHERE TABLE_SCHEMA='{$database}' AND TABLE_NAME = '{$table}'");
            if ($result) {
                $db_result_hahaha->Fetch_All($result, $table_fields);
            }
            $db_hahaha->Close();
            // ---------------------------------------------------
            $fields_ = [];
            foreach ($table_fields as $key => &$fields) 
            {
                foreach ($fields as $key_item => &$item) 
                {
                    if ($key_item == "COLUMN_NAME") {
                        $fields_[] = &$item;
                    }
                }
            }

            $text = [];
            if($doctrine_style)
            {
                $name = str_replace(['_', '-'], [' ', ' '], $table);
                $name = ucwords($name);
                $name = str_replace([' ', '_', '-'], ['', '', ''], $name);
                
            }
            else
            {
                $name = $table;
            }
            
            $this->Generate_PHP_Const($text, $fields_, $output_namespace, $name); 
            // 寫檔
            $filename_ = $output_path . "/" . $name . ".php";
            $output_content_ = implode("\r\n", $text);
            file_put_contents($filename_ , $output_content_);
        } 
        
    }

    public function Generate_PHP_Const(&$text, &$fields_, &$namespace, &$class) 
    {
        // 因為產生器不會做得很複雜 & 需要一直改，所以可以簡單寫
        // 大的才要做特別整理
        $text[] = "<?php";
        $text[] = "";
        $text[] = "namespace {$namespace};";
        $text[] = "";
        $text[] = "class {$class}";
        $text[] = "{";
        // $text[] = "";
        foreach ($fields_ as $key => &$field) 
        {
            $const = strtoupper($field);
            $text[] = "\tconst {$const} = \"{$field}\";";
        }
        $text[] = "";
        $text[] = "} ";
        $text[] = "";

    }

    //-----------------------------------------------------------

    //-----------------------------------------------------------


  

}