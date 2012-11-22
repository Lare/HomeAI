<?php
/**
 *  \Module\Events\Model.php
 *
 *  @package    Module
 *  @subpackage Events
 *  @category   Model
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 */
namespace Module\Events;

defined('HOMEAI_MAINFILE') OR die('No direct access allowed.');
/**
 *  Model -class
 *
 *  Model class for Events module.
 *
 *  @package    Module
 *  @subpackage Events
 *  @category   Model
 *
 *  @project
 *  @case
 *
 *  @author  Lare
 *  @copyright  Lauri Laukkarinen
 *
 *  @date       $Date$
 *  @version    $Rev$
 *  @author     $Author$
 */
class Model extends \Module\Model implements Interfaces\iModel
{
    /**
     *  initialize()
     *
     *  Model initializer method.
     *
     *  @access     public
     *
     *  @return     void
     */
    public function initialize()
    {
    }


    public function getData($date, $type)
    {
        // Specify used query bindings
        $binds = array(
                    'date' => array(\DateTime::createFromFormat('d.m.Y', $date), 'date'),
                    );

        switch ($type)
        {
            case 0:
                $operator = '=';
                $order = 'ASC';
                break;

            case 1:
                $operator = '>=';
                $order = 'ASC';
                break;

            case 2:
                $operator = '<';
                $order = 'DESC';
                break;
        }

        // Specify used query
        $query = sprintf("
                    SELECT
                        `Date`,
                        `ID`,
                        `Title`,
                        `Description`
                    FROM
                        `Event`
                    WHERE
                        (1 = 1)
                        AND (`Date` %s :date)
                    ORDER BY
                        `Date` %s
                    ",
                    $operator,
                    $order
                    );

        $stmt = $this->dbh->query($query, $binds);

        if ($type === 0)
        {
            $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        else
        {
            $data = $stmt->fetchAll(\PDO::FETCH_GROUP|\PDO::FETCH_ASSOC);
        }

        $stmt->closeCursor();
        $stmt = NULL;

        return $data;
    }


    public function saveEvent(&$data)
    {
        return $this->dbh->insert('Event', $data, array(\DB\DBH::PARAM_THROW => true));
    }
}

?>