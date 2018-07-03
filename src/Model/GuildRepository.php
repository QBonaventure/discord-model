<?php
namespace FTC\Discord\Model;

use FTC\Discord\Model\ValueObject\Snowflake;

interface GuildRepository
{
    
    public function save(Guild $guild);
    
    public function getAll() : array;
    
    public function findById(Snowflake $id) : ?Guild;
    
}