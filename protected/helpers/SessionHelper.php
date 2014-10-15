<?php
/**
 * @author Krzysztof Sowa
 */

class SessionHelper
{
    protected static $_session = null;

    /**
     * @return CHttpSession
     */
    protected static function _getSession()
    {
        if(!self::$_session){
            try{
                self::$_session = Yii::app()->session;
            } catch(CException $e){
                throw new CException($e->getMessage());
            }
            //self::$_session->open();
        }
        return self::$_session;
    }

    public static function set($key, $value)
    {
        $session = self::_getSession();
        $session[ $key ] = $value;

        return true;
    }

    public static function get($key, $default = null)
    {
        if(self::hasData($key)){
            $session = self::_getSession();
            return $session[ $key ];
        }

        return $default;
    }

    public static function hasData($key)
    {
        $session = self::_getSession();
        return isset($session[ $key ]);
    }

    public static function unsetData($key)
    {
        if(self::hasData($key)){
            $session = self::_getSession();
            $session[$key] = null;
            unset( $session[$key] );
        }
    }
}
