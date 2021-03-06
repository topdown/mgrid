<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <http://mgrid.mdnsolutions.com/license>.
 */

namespace Mgrid\Source;

/**
 * Interface class
 *
 * @since       0.0.2
 * @author      Renato Medina <medinadato@gmail.com>
 */

interface SourceInterface
{

    /**
     * Runs the query and returns the result as a associative array
     *
     * @return array
     */
    public function execute();

    /**
     * Return the total of records
     *
     * @return int
     */
    public function getNumResults();

    /**
     * Ex: array('c'=>array('tableName'=>'Country'));
     * where c is the table alias. If the table as no alias,
     * c should be the table name
     *
     * @return array
     */
    public function getTableList();

    /**
     * Return possible filters values based on field definition
     * This is mostly used for enum fields where the possible
     * values are extracted
     *
     * Ex: enum('Yes','No','Empty');
     *
     * should return
     *
     * array('Yes'=>'Yes','No'=>'No','Empty'=>'Empty');
     *
     * @param string $field
     *
     * @return mixed
     */
    public function getFilterValuesBasedOnFieldDefinition($field);

    /**
     * Return field type
     * char, varchar, int
     *
     * Note: If the field is enum or set,
     * the value returned must be set or enum,
     * and not the full definition
     *
     * @param string $field
     *
     * @return string
     */
    public function getFieldType($field);

    /**
     * Returns the "main" table
     * the one after select * FROM {MAIN_TABLE}
     *
     * @return string
     */
    public function getMainTable();

    /**
     *
     * Build the order part from the query.
     *
     * The first arg is the field to be ordered and the $order
     * arg is the correspondent order (ASC|DESC)
     *
     * If the $reset is set to true, all previous order should be removed
     *
     * @param string $field
     * @param string $order
     * @param bool $reset
     *
     * @return void
     */
    public function buildQueryOrder($field, $order, $reset = false);

    /**
     * Returns the select object
     *
     * @return mixed
     */
    public function getSelectObject();

    /**
     * returns the selected order
     * that was defined by the user in the query entered
     * and not the one generated by the system
     *
     * If empty a empty array must be returned.
     *
     * Else the array must be like this:
     *
     * Array
     * (
     * [0] => field
     * [1] => ORDER (ASC|DESC)
     * )
     *
     *
     * @return array
     */
    public function getSelectOrder();

    /**
     * Should perform a query based on the provided by the user
     * select the two fields and return an array $field=>$value
     * as result
     *
     * ex: SELECT $field, $value FROM *
     * array('1'=>'Something','2'=>'Number','3'=>'history')....;
     *
     * @param string $field
     * @param string $value
     *
     * @return array
     */
    public function getDistinctValuesForFilters($field, $fieldValue, $order = 'name ASC');

    /**
     *
     * Perform a sqlexp
     *
     * $value =  array ('functions' => array ('AVG'), 'value' => 'Population' );
     *
     * Should be converted to
     * SELECT AVG(Population) FROM *
     *
     * $value =  array ('functions' => array ('SUM','AVG'), 'value' => 'Population' );
     *
     * Should be converted to
     * SELECT SUM(AVG(Population)) FROM *
     *
     * @param array $value
     * @param array $where
     *
     * @return array
     */
    public function getSqlExp(array $value, $where = array());

    /**
     * Adds a fulltext search instead of a addcondition method
     *
     * $field has an index search
     * $field['search'] = array('extra'=>'boolean|queryExpansion','indexes'=>'string|array');
     *
     * if no indexes provided, use the field name
     *
     * boolean =>  IN BOOLEAN MODE
     * queryExpansion =>  WITH QUERY EXPANSION
     *
     * @param string $filter
     * @param string $field
     *
     * @return mixed
     */
    public function addFullTextSearch($filter, $field);

    /**
     * Insert an array of key=>values in the specified table
     * @param string $table
     * @param array $post
     */
    public function insert($table, array $post);

    /**
     * Removes any order in que query
     */
    public function resetOrder();

    /**
     * Removes any offset in que query
     */
    public function resetLimit();

    /**
     * Cache handler.
     *
     * @param Zend_Cache
     */
    public function setCache($cache);

    /**
     * Returns tables primary keys separeted by commas ","
     * This is necessary for mass actions
     *
     * @param string $table     table to get records from
     * @param array  $fields    Fields to fetch
     * @param string $separator Separator for multiple PK's
     */
    public function getMassActionsIds($table, $fields, $separator = '-');

    /**
     *
     * Quotes a string
     *
     * @param string $value Field Value
     */
    public function quoteValue($value);

    /**
     * Fetch pairs from a table
     *
     * @param string $table      Table Name
     * @param string $field      Field Name
     * @param string $fieldValue Field Value
     * @param string $order      Query Order
     *
     */
    public function getValuesForFiltersFromTable($table, $field, $fieldValue, $order = 'name ASC');

    /**
     * Defines total records found
     *
     * @var $total Total records
     */
    public function setNumResults($total);

    /**
     * Returns an array of table identifier columns or PK's
     * 
     * @param string $table Table where to fetch fields
     * 
     * @return array
     * 
     */
    public function getIdentifierColumns($table);
}