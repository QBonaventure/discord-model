<?php

declare(strict_types=1);

namespace FTC\Discord\Model\Aggregate;

use FTC\Discord\Model\ValueObject\Snowflake\UserId;
use FTC\Discord\Model\ValueObject\Name\NickName;
use FTC\Discord\Model\Collection\GuildRoleIdCollection;

class GuildMember
{
    
    /**
     * @var UserId $user
     */
    private $userId;
    
    /**
     * @var NickName $nickname?
     */
    private $nickname;
    
    /**
     * @var GuildRoleIdCollection $rolesId
     */
    private $rolesId;
    
    /**
     * @var boolean $isActive
     */
    private $isActive;
    
    /**
     * @var \DateTime $joinedAt
     */
    private $joinedAt;
    
    private function __construct(UserId $userId, GuildRoleIdCollection $rolesId, \DateTime $joinedAt, NickName $nickname, bool $isActive = true)
    {
        $this->userId = $userId;
        $this->rolesId = $rolesId;
        $this->nickname = $nickname;
        $this->joinedAt = $joinedAt;
        $this->isActive = $isActive;
    }
    
    public function getId() : UserId
    {
        return $this->userId;
    }
    
    public function addRole(GuildRole $role) : self
    {
        $this->rolesId->add($role->getId());
        return $this;
    }
    
    public function getNickname() : NickName
    {
        return $this->nickname;
    }
    
    public function changeNickname(NickName $nickname) : self
    {
        $this->nickname = $nickname;
        
        return $this;
    }
    
    public function getRolesIds() : GuildRoleIdCollection
    {
        return $this->rolesId;
    }
    
    public function getJoinDate() : \DateTime
    {
        return $this->joinedAt;
    }
    
    public function toArray() : array
    {
        return [
            'user_id' => $this->userId->get(),
            'nickname' => $this->nickname->__toString(),
            'roles' => $this->rolesId->toArray(),
        ];
    }
    
    public static function register(UserId $userId, GuildRoleIdCollection $roles, NickName $nickname) : self
    {
        return new self($userId, $roles, new \DateTime(), $nickname);
    }
    
    public static function create(UserId $userId, GuildRoleIdCollection $roles, \DateTime $joinedAt, NickName $nickname, bool $isActive = true) : self
    {
        return new self($userId, $roles, $joinedAt, $nickname, $isActive);
    }
    
}
