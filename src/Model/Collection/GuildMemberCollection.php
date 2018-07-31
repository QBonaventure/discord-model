<?php
declare(strict_types=1);

namespace FTC\Discord\Model\Collection;

use FTC\Discord\Model\Aggregate\GuildMember;
use FTC\Discord\Model\ValueObject\Snowflake;
use FTC\Discord\Model\Collection;
use FTC\Discord\Model\AggregateCollection;
use FTC\Discord\Model\ValueObject\Snowflake\UserId;
use FTC\Discord\Model\IdsCollection;

class GuildMemberCollection implements AggregateCollection
{
    /**
     * @var GuildMember[];
     */
    private $members= [];
    
    public function __construct(GuildMember ...$array)
    {
        array_map(['self', 'add'], $array);
    }
    
    public function getById(Snowflake $id) : GuildMember
    {
        return $this->members[$id->get()];
    }
    
    public function add(GuildMember $member)
    {
        $this->members[$member->getId()->get()] = $member;
        
        return $this;
    }
    
    public function getIds() : IdsCollection
    {
        $ids = array_map(UserId::create($id), array_keys($this->members));
        
        return new GuildMemberIdCollection(...$ids);
    }
    
    public function orderAlphabetically()
    {
        $members = $this->members;
        usort($members, function($a, $b) { return strcmp((string) $a->getNickname(), (string) $b->getNickname()); });
        
        return new self(...$members);
    }

    
    public function count()
    {
        return count($this->members);
    }
    
    
    public function toArray()
    {
        return $this->members;
    }
    
    public function getIterator()
    {
        return $this->members;
    }
}
