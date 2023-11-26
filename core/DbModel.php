<?php
namespace Tioss\core;


use Tioss\controllers\AccountController as Account;
use Tioss\utilHelpers\Functions;
use Tioss\Mail;

abstract class DbModel extends Model
{
    abstract public static function tablename(): string;
    abstract public function aattribute(): array;

    abstract public static function primaryKey(): string;

    public string $code = '';
    public string $reset_code = '';

    public function save()
    {
        $tablename = $this->tablename();
        $aattribute = $this->aattribute();
           
        $params = array_map(fn($attr) => ":$attr", $aattribute);
        $stmt = self::prepare("INSERT INTO $tablename (" .implode(', ', $aattribute).")
                            VALUES  (" .implode(', ', $params).")
        ");

        foreach($aattribute as $attribute)
        {
            $stmt->bindValue(":$attribute", $this->$attribute);
            
        }
       
        $stmt->execute();
        return true;
    }

    public function saveUpdate($id)
    {
        $tablename = $this->tablename();
        $aattribute = $this->aattribute();
           
        $params = array_map(fn($attr) => "$attr = :$attr", $aattribute);
        $stmt = self::prepare("UPDATE $tablename  SET " .implode(', ', $params)." WHERE  pdt_id = :pdt_id");
        
        foreach($aattribute as $attribute)
        {
            $stmt->bindValue(":$attribute", $this->$attribute);            
        }
        $stmt->bindValue(":pdt_id", $id);
        echo '<pre>';
        var_dump($stmt);
        echo '</pre>';
        //exit;

        
        $stmt->execute();
        return true;
    }
    public function delete_product($id)
    {
        $tablename = $this->tablename();
        $stmt = self::prepare("DELETE FROM $tablename WHERE pdt_id = :id");
        $stmt->bindValue(":id", $id);     
        try{
            $stmt->execute();
        } catch(\Exception $e){
            echo Application::$app->view->renderView('_error', 
            [
                'exception' => $e
            ]
            );
        }
        return true;
    }


    public static function findOne(array $where)
    {
        $tableName = static::tablename();
        $aattributes = array_keys($where);
        $data = implode(" OR ", array_map(fn($attr) => "$attr = :$attr", $aattributes ));
        $statement = self::prepare("SELECT * FROM $tableName WHERE  $data ");
        
        foreach($where as $key => $item)
        {
            $statement->bindValue(":$key", $item );
        }
        
        $statement->execute();
        return $statement->fetchObject(static::class);
       
    }

    public static function getProduct()
    {
        $stmt = "SELECT * FROM products";
        $stmt = self::prepare($stmt);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public static function getBrand ()
    {
        $id = $_SESSION['users'] ?? '';
        $stmt = "SELECT brand_name FROM users where id = :id";
        $stmt = self::prepare($stmt);

        $stmt->bindValue(":id", $id);
        //var_dump($id);

        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    
    public static function getUserProduct()
    {
        
        $pdt_brand = self::getBrand()['brand_name'];
        //var_dump($pdt_brand);
        // exit;
        $email = $_SESSION['user']->email;
        $id = $_SESSION['users'];

        $stmt = "SELECT * FROM products where  pdt_brand = :pdt_brand";
        $stmt = self::prepare($stmt);
        $stmt->bindValue(":pdt_brand", $pdt_brand);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

      
    }
    
    public static function getSelectedProduct($pdt_id)
    {
        // echo '<pre>';
        // var_dump($id);
        // echo '</pre>';
        //exit;
        $stmt = "SELECT * FROM products WHERE  pdt_id = :pdt_id";
        $stmt = self::prepare($stmt);
        $stmt->bindValue(":pdt_id", $pdt_id);
        echo '<pre>';
        var_dump($stmt);
        echo '</pre>';
        // exit;
        try{
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch(\Exception $e){
            echo Application::$app->view->renderView('_error', 
            [
                'exception' => $e
            ]
            );
        }
    }

    public function update($pics)
    {
        $id = $_SESSION['users'];

        $stmt = " UPDATE users SET pics = :pics WHERE id = :id " ;

        $stmt = self::prepare($stmt);

        $stmt->bindValue(":pics", $pics );
        $stmt->bindValue(":id", $id );
        $stmt->execute();
        return true;
    }

    public function emailVerify()
    {
        $id = $_SESSION['users'];
        $stmt = "SELECT email_verify FROM users WHERE id = :id";
        $stmt = self::prepare($stmt);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);

    }
    public function email()
    {
        $id = $_SESSION['users'];
        $stmt = "SELECT email FROM users WHERE id = :id";
        $stmt = self::prepare($stmt);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);

    }

    public function verify_code()
    {
        $this->code = Functions::randomInt();
        $expire = time() + (60*2) ;
        $email = $_SESSION['user']->email;

      
        $stmt = "DELETE FROM verify_code WHERE email = :email";
        $stmt = (Application::$app->db->prepare($stmt));
        $stmt->bindValue(":email", $email);
        $stmt->execute();

        $stmt = "INSERT INTO verify_code (code, expires_time, email) 
                VALUES( :code, :expires_time, :email)";
        $stmt = self::prepare($stmt);
        $stmt->bindValue(":code", $this->code);
        $stmt->bindValue(":expires_time", $expire);
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        $message = "your code is ". $this->code;
        $subject = "Email verification";
        $recipient = $email;
        $html_body = "";
        Account::sendSecurityCode($recipient, $email, $subject, $html_body, $message);
        return true;
    }

    public function create_code($email)
    {
        $this->reset_code = Functions::randomInt();
        $expire = time() + (60*10);
        $stmt = "DELETE FROM verify_code WHERE email = :email";
        $stmt = (Application::$app->db->prepare($stmt));
        $stmt->bindValue(":email", $email);
        $stmt->execute();

        $stmt = "INSERT INTO verify_code (code, expires_time, email) 
                VALUES( :code, :expires_time, :email)";
        $stmt = self::prepare($stmt);
        $stmt->bindValue(":code", $this->reset_code);
        $stmt->bindValue(":expires_time", $expire);
        $stmt->bindValue(":email", $email);
        $stmt->execute();
        $message = "your code is ". $this->code;
        $subject = "Email verification";
        $recipient = $email;
        $html_body = "";
        Account::sendSecurityCode($recipient, $email, $subject, $html_body, $message);
        return true;
    }

    public function passwordreset($email)
{
    $user_email = $email;
    $token = bin2hex(random_bytes(16));
    $token_hash = hash('sha256', $token);
    $expires = time() + (60*10);
    $url = "http://localhost:8000/password_reset?v=". bin2hex($token);

    $stmt = "DELETE FROM reset_password WHERE email = :email";
    $stmt = (Application::$app->db->prepare($stmt));
    $stmt->bindValue(":pwdResetEmail", $user_email);
    if($stmt->execute())
    {
        $stmt = "INSERT INTO reset_password 
                    (email, 
                    reset_token_hash, 
                    reset_token_expires_at)
                VALUES( email = :email,
                        reset_token_hash = :reset_token_hash, 
                        reset_token_expires_at = :reset_token_expires_at)";
        $stmt = Application::$app->db->pdo->prepare($stmt);
        $hashToken = password_hash($token, PASSWORD_DEFAULT);
        $stmt->bindValue(":email", $user_email);
        $stmt->bindValue(":reset_token_hash", $token_hash);
        $stmt->bindValue(":reset_token_expires_at", $expires);
        $stmt->execute();          
        return true;
    }
}


    public static function get_code($code)
    {

        $email = $_SESSION['user']->email;
        $stmt = "SELECT code FROM verify_code WHERE email = :email && code = :code";
        $stmt = self::prepare($stmt);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":code", $code);
        $stmt->execute();
        return  $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function get_reset_code($email, $code)
    {

        $stmt = "SELECT code FROM verify_code WHERE email = :email && code = :code";
        $stmt = self::prepare($stmt);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":code", $code);
        $stmt->execute();
        return  $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function get_time($code)
    {

        $email = $_SESSION['user']->email;
        $stmt = "SELECT expires_time FROM verify_code WHERE email = :email && code = :code";
        $stmt = self::prepare($stmt);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":code", $code['code']);
        $stmt->execute();
        return  $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function get_reset_time($email, $code = [])
    {
        $stmt = "SELECT expires_time FROM verify_code WHERE email = :email && code = :code";
        $stmt = self::prepare($stmt);
        $stmt->bindValue(":email", $email);
       
        if(isset($code['code']))
        {
            $stmt->bindValue(":code", $code['code']);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function verified()
    {
        $email = $_SESSION['user']->email;
        $id = $_SESSION['users'];
        $stmt = "UPDATE users SET email_verify = :email WHERE id = :id";
        $stmt = self::prepare($stmt);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        return true;
    }

    public static function reset_password($email, $password)
    {
        $stmt = " UPDATE users SET password = :password WHERE email = :email " ;

        $stmt = self::prepare($stmt);
        $stmt->bindValue(":password", $password );
        $stmt->bindValue(":email", $email );
        $stmt->execute();
        return true;
    }


    public static function prepare($sql)
    {
       
        return Application::$app->db->pdo->prepare($sql);
    }
}