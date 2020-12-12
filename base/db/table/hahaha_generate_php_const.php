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

use g_plib\db\table\hahaha_generate_php_const_key as key;
// use g_plib\db\table\hahaha_generate_php_const_key as generate_php_const_key;

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
 ----------------------------------------------------------- 
參數用法
 ----------------------------------------------------------- 
基本上盡量簡潔，所以用法請看範例
大概是範例貼上去，改一改就可以用了
 ----------------------------------------------------------- 
目前沒有提供完整範例，可能看我用的地方怎樣使用
 ----------------------------------------------------------- 
*/
class hahaha_generate_php_const
{
	use \hahahalib\hahaha_instance_trait;
    
    public $Ip_;
    public $Port_;
	public $User_Name_;
    public $Password_;
	
    //-----------------------------------------------------------
    public function Initial()
    {
        $this->Ip_ = "127.0.0.1";
        $this->Port_ = "9000";
		$this->User_Name_ = "root";
		$this->Password_ = "hahaha";

        return $this;
    }

    public function Initial_Setting(&$ip, &$port, &$username, &$password)
    {
        $this->Ip_ = &$ip;
        $this->Port_ = &$port;
		$this->User_Name_ = $username;
		$this->Password_ = $password;

        return $this;
    }

    //-----------------------------------------------------------
    public function Generate_Table(&$tables, &$database, &$output_path, &$output_namespace = "", $doctrine_style = false, &$pass_tables = ["migrates"])
    {
        if(!is_dir($output_path)) 
        {
            mkdir($output_path, 0777, true);
        }

        $tables_ = &$tables;

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

    public function Generate_Table_From_String(&$content, &$database, &$output_path, &$output_namespace = "", $doctrine_style = false, &$pass_tables = ["migrates"])
    {
        $tables_ = preg_split('/\n|\r\n?\s*/', $content);

        $this->Generate_Table($tables_, 
            $database, 
            $output_path, 
            $output_namespace, 
            $doctrine_style, 
            $pass_tables
        );

    }


    /*
    // 保留字先在前面加_，ex. class use
    // 因為class & db是死的，不做彈性設計
    
    // content textarea string => array
    */
    // --------------------------------------------- 
    // 基本
    // --------------------------------------------- 
    
    // --------------------------------------------- 
    
    // --------------------------------------------- 
    // 設計
    // --------------------------------------------- 
    // $config_output_ = &$config_generate_table_field_[key::OUTPUT];
    // $parameters_ = [
    //     // 輸出
    //     key::OUTPUT => [
    //         key::NAMESPACE => $config_output_[key::NAMESPACE],
    //         key::PATH => $config_output_[key::PATH],
    //         key::CLASS_ => [
    //             key::NAME => $config_output_[key::CLASS_][key::NAME],
    //             key::STYLE => $config_output_[key::CLASS_][key::STYLE],
    //         ],
    //         // ----------------------------------
    //         // 可不填
    //         // ----------------------------------
    //         key::FIELDS => [
    //             key::REPLACE => [
    //                 "accounts" => "p_accounts",
    //                 "p_" => "pp_",
    //             ],
    //         ],
    //         // ----------------------------------
    //         key::INCLUDE_ALL => $config_output_[key::INCLUDE_ALL],

    //     ],
    //     // 略過
    //     key::PASS => [
    //         key::TABLES => [
    //             key::MIGRATIONS,
    //         ],
    //     ],
    //     // 快速使用
    //     key::FAST_USES => [
    //         key::NONE => [
    //             key::PREFIX => [],
    //             key::POSTFIX => [],
    //         ],
    //         key::TABLE => [
    //             key::PREFIX => [key::DATABASE],
    //             key::POSTFIX => [],
    //         ],
    //     ],
    //     // 分類 - 多層確定再看看要不要做
    //     key::CLASSES => [
    //         "accounts",
    //     ],
    //     // 註解
    //     key::COMMENTS => [
    //         // ---------------------------------------------------------
    //         key::NAMESPACE => [
    //             "/*",
    //             " ------------------------------------------------------ ",
    //             "說明",
    //             " ------------------------------------------------------ ",
    //             "*/",
    //         ],
    //         key::CLASS_ => [
    //             "/*",
    //             " ------------------------------------------------------ ",
    //             "說明",
    //             " ------------------------------------------------------ ",
    //             "*/",
    //         ],
    //         // ---------------------------------------------------------
    //         // key::_ORDER => [
    //         //     key::CONST_,
    //         //     key::CONST_CLASS,
    //         //     key::CONST_CONST,
    //         // ],
    //         // ---------------------------------------------------------
    //         key::CONST_ => [
    //                 "// ------------------------------------------------------------------------------ ",
    //                 "// ------------------------------------------------------------------------------ ",
    //                 "// 常數 ",
    //                 "// ------------------------------------------------------------------------------ ",
    //                 "// ------------------------------------------------------------------------------ ",
    //         ],
    //         key::CONST_CLASS => [
    //             key::_COMMENTS => [
    //                 "// ------------------------------------------------------ ",
    //                 "// 常數 - 分類",
    //                 "// ------------------------------------------------------ ",
    //             ],

    //             "accounts" => [
    //                 "// ------------------------------ ",
    //                 "// 會員 ",
    //                 "// ------------------------------ ",
    //             ],
    //         ],
    //         key::CONST_CONST => [
    //                 "// ------------------------------------------------------ ",
    //                 "// 常數 ",
    //                 "// ------------------------------------------------------ ",
    //         ],
    //         // ---------------------------------------------------------
    //     ],
    // ];

    // $text_deal_main_->Generate_Table_Custom_From_String($content_,
    //     $database_,
    //     $parameters_
    // );
    // --------------------------------------------- 

    // --------------------------------------------- 
    // demo
    // --------------------------------------------- 

    // --------------------------------------------- 
    
    public function Generate_Table_Custom(&$tables, &$database, &$parameters = [])
    {
        $output_ = &$parameters[key::OUTPUT];
        $pass_ = &$parameters[key::PASS];
        $fast_uses_ = &$parameters[key::FAST_USES];
        $classes_ = &$parameters[key::CLASSES];
        $comments_ = &$parameters[key::COMMENTS];
        

        if(!is_dir($output_[key::PATH])) 
        {
            mkdir($output_[key::PATH], 0777, true);
        }

        $tables_ = &$tables;

        // ----------------------------- 
        // 過濾
        // ----------------------------- 
        foreach ($tables_ as $key => &$table) 
        {
            $table_name = trim($table);
            if (in_array($table, $pass_[key::TABLES])) {
                unset($tables_[$key]);
            } 
            else if (empty($table_name)) {
                unset($tables_[$key]);
            }        
        } 

        // ----------------------------- 
        // 分類
        // ----------------------------- 
        // fields
        $fields_ = []; 

        // fields_class
        $fields_class_ = [];
        foreach ($tables_ as $key_table => &$table) 
        {
            $is_class = false;
            foreach ($classes_ as $key_class => &$class) 
            {
                $pos_ = strpos($table, $class);

                if($pos_ === 0) 
                {
                    // 找到分類
                    if(empty($fields_class_[$class]))
                    {
                        $fields_class_[$class] = [];
                    } 

                    // 
                    $fields_class_[$class][] = &$table;
                    $is_class = true;
                    break;
                }
            }
            
            if(!$is_class)
            {
                $fields_[] = &$table;
            }
        }

        
        // ----------------------------- 
        // style
        // ----------------------------- 
        $text = [];
        
        // 替換名子
        if(!empty($output_[key::CLASS_][key::NAME]) ) 
        {
            $name_ = $output_[key::CLASS_][key::NAME];
        } 
        else
        {
            $name_ = $database;
        }

        // 樣式處理
        if($output_[key::CLASS_][key::STYLE] == key::_) 
        {
            $name_ = str_replace([' ', '_', '-'], ['_', '_', '_'], $name_);
        }
        else if($output_[key::CLASS_][key::STYLE] == key::PSR) 
        {
            $name_ = str_replace(['_', '-'], [' ', ' '], $database);
            $name_ = ucwords($name_);
            $name_ = str_replace([' ', '_', '-'], ['', '', ''], $name_);
        }

        // ----------------------------- 
        // fast_use
        // ----------------------------- 
        $fast_use_strings_ = [];
        foreach ($fast_uses_ as $key_fast_use => &$fast_use) 
        {
            $temp_ = "";
            $first_ = true;
            // 前綴
            foreach ($fast_use[key::PREFIX] as $key_prefix => &$prefix) 
            {
                if($output_[key::CLASS_][key::STYLE] == key::_) 
                {
                    if($first_)
                    {
                        $first_ = false;
                        $temp_ .= $prefix;
                    }
                    else
                    {
                        $temp_ .= key::_ . $prefix;
                    }
                }
                else if($output_[key::CLASS_][key::STYLE] == key::PSR) 
                {
                    if($first_)
                    {
                        $first_ = false;
                        $temp_ .= strtolower($prefix);
                    }
                    else
                    {
                        $temp_ .= ucfirst(strtolower($prefix));
                    }
                }
            }
            // 主要
            if($output_[key::CLASS_][key::STYLE] == key::_) 
            {
                if($first_)
                {
                    $first_ = false;
                    $temp_ .= $name_;
                }
                else
                {
                    $temp_ .= key::_ . $name_;
                }
            }
            else if($output_[key::CLASS_][key::STYLE] == key::PSR) 
            {
                if($first_)
                {
                    $first_ = false;
                    $temp_ .= strtolower($name_);
                }
                else
                {
                    $temp_ .= ucfirst(strtolower($name_));
                }
            }
            // 後綴
            foreach ($fast_use[key::POSTFIX] as $key_postfix => &$postfix) 
            {
                if($output_[key::CLASS_][key::STYLE] == key::_) 
                {
                    if($first_)
                    {
                        $first_ = false;
                        $temp_ .= $postfix;
                    }
                    else
                    {
                        $temp_ .= key::_ . $postfix;
                    }
                }
                else if($output_[key::CLASS_][key::STYLE] == key::PSR) 
                {
                    if($first_)
                    {
                        $first_ = false;
                        $temp_ .= strtolower($postfix);
                    }
                    else
                    {
                        $temp_ .= ucfirst(strtolower($postfix));
                    }
                }
            }

            // 存入
            $fast_use_strings_[] = &$temp_;
            unset($temp_); 
        }

        // ----------------------------- 
        // 處理
        // ----------------------------- 
        $settings_ = [
            key::NAMESPACE => &$output_[key::NAMESPACE],
            key::CLASS_ => &$name_,
            key::CLASSES => &$classes_,
            key::FIELDS_CLASS => &$fields_class_,
            key::FIELDS => &$fields_,
            key::FAST_USES => &$fast_use_strings_,
            key::COMMENTS => &$comments_,
        ];
        
        $this->Generate_PHP_Const_Custom($text, $settings_, $parameters); 
        // 寫檔
        $filename_ = $output_[key::PATH] . "/" . $name_ . ".php";
        $output_content_ = implode("\r\n", $text);
        file_put_contents($filename_ , $output_content_);
        
    }

    public function Generate_Table_Custom_From_String(&$content, &$database, &$parameters = [])
    {
        $tables_ = preg_split('/\n|\r\n?\s*/', $content);

        $this->Generate_Table_Custom($tables_, $database, $parameters);

    }

    //-----------------------------------------------------------
    public function Generate_Table_Field(&$tables, &$database, &$output_path, &$output_namespace = "", $doctrine_style = false, &$pass_tables = ["migrates"])
    {
        if(!is_dir($output_path)) 
        {
            mkdir($output_path, 0777, true);
        }

        $tables_ = &$tables;

        foreach ($tables_ as $key => &$table) 
        {
            $table_name = trim($table);
            if (empty($table_name)) {
                continue;
            }

            // ---------------------------------------------------
            $db_hahaha = new \hahahalib\hahaha_db_mysql;
            $db_result_hahaha = new \hahahalib\hahaha_db_mysql_result;
            $db_hahaha->Connect("{$this->Ip_}:{$this->Port_}", $this->User_Name_, $this->Password_, $database);
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

    public function Generate_Table_Field_From_String(&$content, &$database, &$output_path, &$output_namespace = "", $doctrine_style = false, &$pass_tables = ["migrates"])
    {
        $tables_ = preg_split('/\n|\r\n?\s*/', $content);

        $this->Generate_Table_Field($tables_, 
            $database, 
            $output_path, 
            $output_namespace, 
            $doctrine_style, 
            $pass_tables,
        );

    }

    
    /*
    // 保留字先在前面加_，ex. class use
    // 因為class & db是死的，不做彈性設計
    
    // content textarea string => array
    */
    // --------------------------------------------- 
    // 基本
    // --------------------------------------------- 
    
    // --------------------------------------------- 
    
    // --------------------------------------------- 
    // 設計
    // --------------------------------------------- 
    // $config_output_ = &$config_generate_table_field_[key::OUTPUT];
    // $parameters_ = [
    //     // 輸出
    //     key::OUTPUT => [
    //         key::NAMESPACE => $config_output_[key::NAMESPACE],
    //         key::PATH => $config_output_[key::PATH],
    //         key::CLASS_ => [
    //             key::STYLE => $config_output_[key::CLASS_][key::STYLE],
    //         ],
    //         // ----------------------------------
    //         // 可不填
    //         // ----------------------------------
    //         key::FIELDS => [
    //             key::REPLACE => [
    //                 // "accounts" => "p_accounts",
    //                 // "p_" => "pp_",
    //             ],
    //         ],
    //         // ----------------------------------
    //         key::INCLUDE_ALL => $config_output_[key::INCLUDE_ALL],
    //     ],
    //     // 略過
    //     key::PASS => [
    //         key::TABLES => [
    //             key::MIGRATIONS,
    //         ],
    //     ],
    //     // 快速使用
    //     key::FAST_USES => [
    //         key::NONE => [
    //             key::PREFIX => [],
    //             key::POSTFIX => [],
    //         ],
    //         key::TABLE => [
    //             key::PREFIX => [key::TABLE],
    //             key::POSTFIX => [],
    //         ],
    //     ],
    //     // 註解
    //     key::COMMENTS => [
    //         // ---------------------------------------------------------
    //         key::NAMESPACE => [
    //             "/*",
    //             " ------------------------------------------------------ ",
    //             "說明",
    //             " ------------------------------------------------------ ",
    //             "*/",
    //         ],
    //         key::CLASS_ => [
    //             "/*",
    //             " ------------------------------------------------------ ",
    //             "說明",
    //             " ------------------------------------------------------ ",
    //             "*/",
    //         ],
    //         // ---------------------------------------------------------
    //         // key::_ORDER => [
    //         //     key::CONST_,
    //         //     key::CONST_CLASS,
    //         //     key::CONST_CONST,
    //         // ],
    //         // ---------------------------------------------------------
    //         key::CONST_ => [
    //                 "// ------------------------------------------------------------------------------ ",
    //                 "// ------------------------------------------------------------------------------ ",
    //                 "// 常數 ",
    //                 "// ------------------------------------------------------------------------------ ",
    //                 "// ------------------------------------------------------------------------------ ",
    //         ],
    //         key::CONST_CLASS => [
    //             key::_COMMENTS => [
    //                 "// ------------------------------------------------------ ",
    //                 "// 常數 - 分類",
    //                 "// ------------------------------------------------------ ",
    //             ],

    //             "accounts" => [
    //                 "// ------------------------------ ",
    //                 "// 會員 ",
    //                 "// ------------------------------ ",
    //             ],
    //         ],
    //         key::CONST_CONST => [
    //                 "// ------------------------------------------------------ ",
    //                 "// 常數 ",
    //                 "// ------------------------------------------------------ ",
    //         ],
    //         // ---------------------------------------------------------
    //     ],
    // ];

    // $text_deal_main_->Generate_Table_Field_Custom_From_String($content_,
    //     $database_,
    //     $parameters_
    // );
    // --------------------------------------------- 

    // --------------------------------------------- 
    // demo
    // --------------------------------------------- 

    // --------------------------------------------- 
    
    public function Generate_Table_Field_Custom(&$tables, &$database, &$parameters = [])
    {
        $output_ = &$parameters[key::OUTPUT];
        $pass_ = &$parameters[key::PASS];
        $fast_uses_ = &$parameters[key::FAST_USES];
        $comments_ = &$parameters[key::COMMENTS];

        if(!is_dir($output_[key::PATH])) 
        {
            mkdir($output_[key::PATH], 0777, true);
        }

        $tables_ = &$tables;

        // ----------------------------- 
        // 過濾
        // ----------------------------- 
        foreach ($tables_ as $key => &$table) 
        {
            $table_name = trim($table);
            if (in_array($table, $pass_[key::TABLES])) {
                unset($tables_[$key]);
            } 
            else if (empty($table_name)) {
                unset($tables_[$key]);
            }        
        } 

        foreach ($tables_ as $key => &$table) {
            $table_name = trim($table);
            if (empty($table_name)) {
                continue;
            }

            // ---------------------------------------------------
            $db_hahaha = new \hahahalib\hahaha_db_mysql;
            $db_result_hahaha = new \hahahalib\hahaha_db_mysql_result;
            $db_hahaha->Connect("{$this->Ip_}:{$this->Port_}", $this->User_Name_, $this->Password_, $database);
            $db_hahaha->Set_Names("utf8");

            // 查資料表欄位
            $table_fields = [];
            $result = $db_hahaha->Query("SELECT * FROM information_schema.`COLUMNS` WHERE TABLE_SCHEMA='{$database}' AND TABLE_NAME = '{$table}'");
            if ($result) {
                $db_result_hahaha->Fetch_All($result, $table_fields);
            }
            $db_hahaha->Close();
            // ---------------------------------------------------
            // -----------------------------
            // 分類
            // -----------------------------
            $fields_temp_ = [];
            foreach ($table_fields as $key => &$fields) {
                foreach ($fields as $key_item => &$item) {
                    if ($key_item == "COLUMN_NAME") {
                        $fields_temp_[] = &$item;
                    }
                }
            }

            // ---------------------------------------------------
            // 注意
            // ---------------------------------------------------
            // 預留可能做table const分類，暫時保留，不確定要根據分類還是位置
            // 所以這邊轉接
            // ---------------------------------------------------
            // fields
            $fields_ = &$fields_temp_;

            // ----------------------------- 
            // style
            // ----------------------------- 
            $text = [];
            
            // 替換名子
            $name_ = $table;

            // 樣式處理
            if($output_[key::CLASS_][key::STYLE] == key::_) 
            {
                $name_ = str_replace([' ', '_', '-'], ['_', '_', '_'], $name_);
            }
            else if($output_[key::CLASS_][key::STYLE] == key::PSR) 
            {
                $name_ = str_replace(['_', '-'], [' ', ' '], $name_);
                $name_ = ucwords($name_);
                $name_ = str_replace([' ', '_', '-'], ['', '', ''], $name_);
            }

            // ----------------------------- 
            // fast_use
            // ----------------------------- 
            $fast_use_strings_ = [];
            foreach ($fast_uses_ as $key_fast_use => &$fast_use) 
            {
                $temp_ = "";
                $first_ = true;
                // 前綴
                foreach ($fast_use[key::PREFIX] as $key_prefix => &$prefix) 
                {
                    if($output_[key::CLASS_][key::STYLE] == key::_) 
                    {
                        if($first_)
                        {
                            $first_ = false;
                            $temp_ .= $prefix;
                        }
                        else
                        {
                            $temp_ .= key::_ . $prefix;
                        }
                    }
                    else if($output_[key::CLASS_][key::STYLE] == key::PSR) 
                    {
                        if($first_)
                        {
                            $first_ = false;
                            $temp_ .= strtolower($prefix);
                        }
                        else
                        {
                            $temp_ .= ucfirst(strtolower($prefix));
                        }
                    }
                }
                // 主要
                if($output_[key::CLASS_][key::STYLE] == key::_) 
                {
                    if($first_)
                    {
                        $first_ = false;
                        $temp_ .= $name_;
                    }
                    else
                    {
                        $temp_ .= key::_ . $name_;
                    }
                }
                else if($output_[key::CLASS_][key::STYLE] == key::PSR) 
                {
                    if($first_)
                    {
                        $first_ = false;
                        $temp_ .= strtolower($name_);
                    }
                    else
                    {
                        $temp_ .= ucfirst(strtolower($name_));
                    }
                }
                // 後綴
                foreach ($fast_use[key::POSTFIX] as $key_postfix => &$postfix) 
                {
                    if($output_[key::CLASS_][key::STYLE] == key::_) 
                    {
                        if($first_)
                        {
                            $first_ = false;
                            $temp_ .= $postfix;
                        }
                        else
                        {
                            $temp_ .= key::_ . $postfix;
                        }
                    }
                    else if($output_[key::CLASS_][key::STYLE] == key::PSR) 
                    {
                        if($first_)
                        {
                            $first_ = false;
                            $temp_ .= strtolower($postfix);
                        }
                        else
                        {
                            $temp_ .= ucfirst(strtolower($postfix));
                        }
                    }
                }

                // 存入
                $fast_use_strings_[] = &$temp_;
                unset($temp_); 
            }
            
            // ----------------------------- 
            // 處理
            // ----------------------------- 
            $settings_ = [
                key::NAMESPACE => &$output_[key::NAMESPACE],
                key::CLASS_ => &$name_,
                key::FIELDS => &$fields_,
                key::FAST_USES => &$fast_use_strings_,
                key::COMMENTS => &$comments_,
            ];
            
            $this->Generate_PHP_Const_Custom($text, $settings_, $parameters); 
            // 寫檔
            $filename_ = $output_[key::PATH] . "/" . $name_ . ".php";
            $output_content_ = implode("\r\n", $text);
            file_put_contents($filename_ , $output_content_);
        } 
        
    }

    public function Generate_Table_Field_Custom_From_String(&$content, &$database, &$parameters = [])
    {
        $tables_ = preg_split('/\n|\r\n?\s*/', $content);

        $this->Generate_Table_Field_Custom($tables_, $database, $parameters);

    }

    //-----------------------------------------------------------
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
            $const = trim( strtoupper($field) );
            $const = str_replace([" ", "-"], ["_", "_"], $const);
            $text[] = "\tconst {$const} = \"{trim($field)}\";";
        }
        $text[] = "";
        $text[] = "} ";
        $text[] = "";

    }

    public function Generate_PHP_Const_Custom(&$text, &$settings, &$parameters) 
    {
        $fast_uses_ = &$settings[key::FAST_USES];
        $comments_ = &$settings[key::COMMENTS];
        $comments_namespace_ = &$comments_[key::NAMESPACE];
        $classes_ = &$settings[key::CLASSES];
        $comments_class_ = &$comments_[key::CLASS_];
        $comments_const_ = &$comments_[key::CONST_];
        $comments_const_class_ = &$comments_[key::CONST_CLASS];
        $comments_const_const_ = &$comments_[key::CONST_CONST];

        //
        $is_replace_field_ = false;
        if(!empty($parameters[key::OUTPUT][key::FIELDS][key::REPLACE])) {
            $replace_fields_ = &$parameters[key::OUTPUT][key::FIELDS][key::REPLACE];
            $replace_from_ = array_keys($replace_fields_);
            $replace_to_ = array_values($replace_fields_);
            $is_replace_field_ = true;
        }        
        //

        // 因為產生器不會做得很複雜 & 需要一直改，所以可以簡單寫
        // 大的才要做特別整理
        $text[] = "<?php";
        $text[] = "";
        $text[] = "namespace {$settings[key::NAMESPACE]};";
        $text[] = "";
        // fast_use
        if(!empty($fast_uses_))
        {
            $text[] = "/*";
            foreach ($fast_uses_ as $key => &$fast_use) 
            {
                $text[] = "use {$settings[key::NAMESPACE]}\\{$settings[key::CLASS_]} as {$fast_use}";
                $text[] = "";
            }
            $text[] = "*/";
        }
        $text[] = "";
        
        // comments_namespace
        if(!empty($comments_namespace_))
        {
            foreach ($comments_namespace_ as $key => &$comment) 
            {
                $text[] = "{$comment}";
            }
        }
        $text[] = "";
        
        // comments_class
        if(!empty($comments_class_))
        {
            foreach ($comments_class_ as $key => &$comment) 
            {
                $text[] = "{$comment}";
            }
        }
        
        //
        $text[] = "class {$settings[key::CLASS_]}";
        $text[] = "{";
        // comments_const
        if(!empty($comments_const_)) 
        {
            $text[] = "";
            foreach ($comments_const_ as $key => &$comment) 
            {
                $text[] = "\t{$comment}";
            }
            $text[] = "";
        }         
        //
        if(!empty($classes_))
        {
            foreach ($classes_ as $key => &$class) 
            {
                if(!empty($comments_const_class_[key::_COMMENTS])) 
                {
                    foreach ($comments_const_class_[key::_COMMENTS] as $key_comment => &$comment) 
                    {
                        $text[] = "\t{$comment}";
                    }
                    $text[] = "";
                }
                if(!empty($comments_const_class_[$class]))
                {
                    foreach ($comments_const_class_[$class] as $key_comment => &$comment) 
                    {
                        $text[] = "\t{$comment}";
                    }  
                }
                if(!empty($settings[key::FIELDS_CLASS]) && !empty($settings[key::FIELDS_CLASS][$class]) ) 
                {
                    foreach ($settings[key::FIELDS_CLASS][$class] as $key_field => &$field) 
                    {
                        // const 
                        $field_temp_ = $field;
                        if($is_replace_field_) 
                        {
                            $field_temp_ = str_replace($replace_from_, $replace_to_, $field_temp_);
                        }     
                        $const = trim( strtoupper($field_temp_) );
                        $const = str_replace([" ", "-"], ["_", "_"], $const);
                                           
                        $text[] = "\tconst {$const} = \"{$field}\";";
                    }
                }
            }
        }        
        // 
        $text[] = "";
        // comments_const_const
        if(!empty($comments_const_const_)) 
        {
            foreach ($comments_const_const_ as $key => &$comment) 
            {
                $text[] = "\t{$comment}";
            }
        }        
        //
        foreach ($settings[key::FIELDS] as $key => &$field) 
        {
            $field_temp_ = $field;
            if($is_replace_field_) 
            {
                $field_temp_ = str_replace($replace_from_, $replace_to_, $field_temp_);
            }     
            $const = trim( strtoupper($field_temp_) );
            $const = str_replace([" ", "-"], ["_", "_"], $const);
            $text[] = "\tconst {$const} = \"{$field}\";";
        }
        $text[] = "";
        $text[] = "} ";
        $text[] = "";

    }

    //-----------------------------------------------------------

    //-----------------------------------------------------------


  

}