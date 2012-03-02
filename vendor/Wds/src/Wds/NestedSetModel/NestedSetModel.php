<?php

/**
 * WDS GROUP
 *
 * @name        NestedSetModel.php
 * @category    Wds
 * @package     Wds_NestedSetModel
 * @author      Thuy Dinh Xuan <thuydx@wds.vn>
 * @copyright   Copyright (c)2008-2010 WDS GROUP. All rights reserved
 * @license     http://wds.vn/license/     WDS Software License
 * @version     $1.0.0$
 * 9:42:57 PM - Mar 1, 2012
 *
 * LICENSE
 *
 * This source file is copyrighted by WDS, full details in LICENSE.txt.
 * It is also available through the Internet at this URL:
 * http://wds.vn/license/
 * If you did not receive a copy of the license and are unable to
 * obtain it through the Internet, please send an email
 * to license@wds.vn so we can send you a copy immediately.
 *
 */

namespace Wds\NestedSetModel;

interface NestedSetModel 
{
     
    var $table_name;
    var $left_column_name;
    var $right_column_name;
    var $primary_key_column_name;

    /**
     * Constructor
     *
     * @access	public
     */
    public function NestedSetModel()
    {
        
    }

    // -------------------------------------------------------------------------
    //  OBJECT INITIALISATION METHODS
    //
    //  For setting instance properties
    //
    // -------------------------------------------------------------------------

    /**
     *  On initialising the instance, this method should be called to set the
     *  database table name that we're dealing and also to identify the names
     *  of the left and right value columns used to form the tree structure.
     *  Typically, this would be done automatically by the model class that
     *  extends this "base" class (eg. a Categories class would set the table_name
     *  to "categories", a Site_structure class would set the table_name to
     *  "pages" etc)
     *
     *  @param string $table_name The name of the db table to use
     *  @param string $left_column_name The name of the field representing the left identifier
     *  @param string $right_column_name The name of the field representing the right identifier
     *  @return void
     *
     */
    function setControlParams($table_name,$left_column_name = "lft",$right_column_name = "rgt");

    /**
     * Used to identify the primary key of the table in use. Commonly, this will
     * be an auto_incrementing ID column (eg CategoryId)
     *
     * @param string $primary_key_name
     * @return void
     */
    function setPrimaryKeyColumn($primary_key_name);


    // -------------------------------------------------------------------------
    //  NODE MANIPULATION FUNCTIONS
    //
    //  Methods to add/remove nodes in your tree
    //
    // -------------------------------------------------------------------------


    /**
     * Adds the first entry to the table
     * @param     $extrafields  An array of field->value pairs for the database record
     * @return    $node an array of left and right values
     */
    function initialiseRoot($extrafields = array());
    
    /**
     * inserts a new node as the first child of the supplied parent node
     * @param array $parentNode The node array of the parent to use
     * @param array $extrafields An associative array of fieldname=>value for the other fields in the recordset
     * @return array $childNode An associative array representing the new node
     */
    function insertNewChild($parentNode, $extrafields = array());

    /**
     * Same as insertNewChild except the new node is added as the last child
     * @param array $parentNode The node array of the parent to use
     * @param array $extrafields An associative array of fieldname=>value for the other fields in the recordset
     * @return array $childNode An associative array representing the new node
     */
    function appendNewChild($parentNode, $extrafields = array());
    
    /**
     * Adds a new node to the left of the supplied focusNode
     * @param array $focusNode The node to use as the position marker
     * @param array $extrafields An associative array of node attributes
     * @return array $siblingNode The new node
     */
    function insertSibling($focusNode, $extrafields);

    /**
     * Adds a new node to the right of the supplied focusNode
     * @param array $focusNode The node to use as the position marker
     * @param array $extrafields An associative array of node attributes
     * @return array $siblingNode The New Node
     */
    function appendSibling($focusNode, $extrafields);

    /**
     * Empties the table currently in use - use with extreme caution!
     */
    function deleteTree();

    /**
     * Deletes the given node (and any children) from the tree table
     * @param array $node The node to remove from the tree
     * @return array $newnode The node that replaced the deleted node
     */
    function deleteNode($node);

    // -------------------------------------------------------------------------
    //  MODIFY/REORGANISE TREE
    //
    //  Methods to move nodes around the tree. Method names should be
    //  relatively self-explanatory! Hopefully ;)
    //
    // -------------------------------------------------------------------------

    /**
     * Moves the given node to make it the next sibling of "target"
     * @param array $node The node to move
     * @param array $target The node to use as the position marker
     * @return array $newpos The new left and right values of the node moved
     */
    function setNodeAsNextSibling($node, $target);

    /**
     * Moves the given node to make it the prior sibling of "target"
     * @param array $node The node to move
     * @param array $target The node to use as the position marker
     * @return array $newpos The new left and right values of the node moved
     */
    function setNodeAsPrevSibling($node, $target);
    
    /**
     * Moves the given node to make it the first child of "target"
     * @param array $node The node to move
     * @param array $target The node to use as the position marker
     * @return array $newpos The new left and right values of the node moved
     */
    function setNodeAsFirstChild($node, $target);

    /**
     * Moves the given node to make it the last child of "target"
     * @param array $node The node to move
     * @param array $target The node to use as the position marker
     * @return array $newpos The new left and right values of the node moved
     */
    function setNodeAsLastChild($node, $target);

// -------------------------------------------------------------------------
//  QUERY METHODS
//
//  Selecting nodes from the tree
//
// -------------------------------------------------------------------------

    /**
     * Selects the first node to match the given where clause argument
     * @param string $whereArg Any valid SQL to follow the WHERE keyword in an SQL statement
     * @return array $resultNode The node returned from the query
     */
    function getNodeWhere($whereArg = "1=1");

    /**
     * Returns the node identified by the given left value
     * @param integer $leftval The left value to use to select the node
     * @return array $resultNode The node returned
     */
    function getNodeWhereLeft($leftval);
    
    /**
     * Returns the node identified by the given right value
     * @param integer $rightval The right value to use to select the node
     * @return array $resultNode The node returned
     */
    function getNodeWhereRight($rightval);

    /**
     * Returns the root node
     * @return array $resultNode The node returned
     */
    function getRoot();

    /**
     * Returns the node with the appropriate primary key field value.
     * Typically, this will be an auto_incrementing primary key column
     * such as categoryid
     * @param mixed $primarykey The value to look up in the primary key index
     * @return array $resultNode The node returned
     */
    function getNodeFromId($primarykey);

    /**
     * Returns the first child node of the given parentNode
     * @param array $parentNode The parent node to use
     * @return array $resultNode The first child of the parent node supplied
     */
    function getFirstChild($parentNode);

    /**
     * Returns the last child node of the given parentNode
     * @param array $parentNode The parent node to use
     * @return array $resultNode the last child of the parent node supplied
     */
    function getLastChild($parentNode);

    /**
     * Returns the node that is the immediately prior sibling of the given node
     * @param array $currNode The node to use as the initial focus of enquiry
     * @return array $resultNode The node returned
     */
    function getPrevSibling($currNode);

    /**
     * Returns the node that is the next sibling of the given node
     * @param array $currNode The node to use as the initial focus of enquiry
     * @return array $resultNode The node returned
     */
    function getNextSibling($currNode);

    /**
     * Returns the node that represents the parent of the given node
     * @param array $currNode The node to use as the initial focus of enquiry
     * @return array $resultNode the node returned
     */
    function getAncestor($currNode);


// -------------------------------------------------------------------------
//  NODE TEST METHODS
//
//  Boolean tests for nodes
//
// -------------------------------------------------------------------------


    /**
     * Returns true or false
     * (in reality, it checks to see if the given left and
     * right values _appear_ to be valid not necessarily that they _are_ valid)
     * @param array $node The node to test
     * @return boolean
     */
    function checkIsValidNode($node);

    /**
     * Tests whether the given node has an ancestor
     * (effectively the opposite of isRoot yes|no)
     * @param array $node The node to test
     * @return boolean
     */
    function checkNodeHasAncestor($node);

    /**
     * Tests whether the given node has a prior sibling or not
     * @param array $node
     * @return boolean
     */
    function checkNodeHasPrevSibling($node);

    /**
     * Test to see if node has siblings after itself
     * @param array $node The node to test
     * @return boolean
     */
    function checkNodeHasNextSibling($node);

    /**
     * Test to see if node has children
     * @param array $node The node to test
     * @return boolean
     */
    function checkNodeHasChildren($node);

    /**
     * Test to see if the given node is also the root node
     * @param array $node The node to test
     * @return boolean
     */
    function checkNodeIsRoot($node);

    /**
     * Test to see if the given node is a leaf node (ie has no children)
     * @param array $node The node to test
     * @return boolean
     */
    function checkNodeIsLeaf($node);

    /**
     * Test to see if the first given node is a child of the second given node
     * @param array $testNode the node to test for child status
     * @param array $controlNode the node to use as the parent or ancestor
     * @return boolean
     */
    function checkNodeIsChild($testNode, $controlNode);

    /**
     * Test to determine whether testNode is infact also controlNode (is A === B)
     * @param array $testNode The node to test
     * @param array $controlNode The node prototype to use for the comparison
     * @return boolean
     */
    function checkNodeIsEqual($testNode, $controlNode);

    /**
     * Combination method of IsChild and IsEqual
     * @param array $testNode The node to test
     * @param array $controlNode The node prototype to use for the comparison
     * @return boolean
     */
    function checkNodeIsChildOrEqual($testNode, $controlNode);

    // -------------------------------------------------------------------------
    //  TREE QUERY METHODS
    //
    //  Query the tree itself
    //
    // -------------------------------------------------------------------------

    /**
     * Returns the number of descendents that a node has
     * @param array $node The node to query
     * @return integer The number of descendents
     */
    function getNumberOfChildren($node);

    /**
     * Returns the tree level for the given node (assuming root node is at level 0)
     * @param array $node The node to query
     * @return integer The level of the supplied node
     */
    function getNodeLevel($node);

    /**
     * Returns an array of the tree starting from the supplied node
     * @param array $node The node to use as the starting point (typically root)
     * @return array $tree_handle The tree represented as an array to assist with
     *                            the other tree traversal operations
     */
    function getTreePreorder($node);
    

    /**
     * Returns the next element from the tree and updates the tree_handle with the
     * new positions
     * @param array $tree_handle Passed by reference to allow for modifications
     * @return array The next node in the tree
     */
    function getTreeNext(&$tree_handle);

    /**
     * Returns the given attribute (database field) for the current node in $tree_handle
     * @param array $tree_handle The tree as an array
     * @param string $attribute A string containing the fieldname to retrieve
     * @return string The value requested
     */
    function getTreeAttribute($tree_handle,$attribute);

    /**
     * Returns the current node of the tree contained in $tree_handle
     * @param array $tree_handle The tree as an array
     * @return array The left and right values of the current node
     */
    function getTreeCurrent($tree_handle);
    
    /**
     * Returns the current level from the tree
     * @param array $tree_handle The tree as an array
     * @return integer The integer value of the current level
     */
    function getTreeLevel($tree_handle);
        


    // -------------------------------------------------------------------------
        //   NODE FIELD QUERIES
        //
        // -------------------------------------------------------------------------

     /**
      * Queries the database for the value of the given field
      *
      * Thanks to CI user hkk for poiting out a bug in this method. Fixed.
      *
      * @param array $node The node to be queried
      * @param string $fieldname The name of the field to query
      * @return string $retval The value of the field for the node looked up
      */
     function getNodeAttribute($node, $fieldname);

    /**
     * Renders the fields for each node starting at the given node
     * @param array $node The node to start with
     * @param array $fields The fields to display for each node
     * @return string Sample HTML render of tree
     */
    function getSubTreeAsHTML($node, $fields = array());


    /**
     * Renders the entire tree as per getSubTreeAsHTML starting from root
     * @param array $fields An array of the fields to display
     * @return Object subtreeAsHTML
     */
    function getTreeAsHTML($fields=array());

// -------------------------------------------------------------------------
//  INTERNALS
//
//  Private, internal methods
//
// -------------------------------------------------------------------------

    /**
     *  _setNewNode
     *
     *  Inserts a new node into the tree
     *
     *  @param array $node An array containing the left and right values to use
     *  @param array $extrafields An associative array of field names to values for \
     *                          additional columns in tree table (eg CategoryName etc)
     *
     *  @return boolean True/False dependent upon the success of the operation
     *  @access private
     *  @return boolean
     */
    private function _setNewNode($node, $extrafields);



    /**
     * The method that performs moving/renumbering operations
     * @param array $node The node to move
     * @param array $targetValue Position integer to use as the target
     * @return array $newpos The new left and right values of the node moved
     * @access private
     * @return int newposition
     */
    private function _moveSubtree($node, $targetValue);
    /**
     * _modifyNode
     *
     * Adds $changeVal to all left and right values that are greater than or
     * equal to $node_int
     *
     * @param  $node_int The value to start the shift from
     * @param  $changeVal unsigned integer value for change
     * @access private
     * @return boolean
     */
    private function _modifyNode($node_int, $changeVal);
         
    /**
     * _modifyNodeRange
     *
     * @param $lowerbound integer value of lowerbound of range to move
     * @param $upperbound integer value of upperbound of range to move
     * @param $changeVal unsigned integer of change amount
     * @access private
     */
    private function _modifyNodeRange($lowerbound, $upperbound, $changeVal);

} // END: Class Nested_sets
