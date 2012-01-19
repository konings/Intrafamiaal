<?php

/**
 * @Entity
 * @Table(name="test123")
 */


class Default_Model_Test
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @Column(type="string") */
    private $name;

    public function setName($string) {
        $this->name = $string;
        return true;
    }
}
