<?php

namespace Signes\Acl;

class Acl extends AclManager
{

    /**
     * Check if resource is available
     *
     * @param $resource
     * @param UserInterface $user
     * @return bool
     */
    public function isAllow($resource, UserInterface $user = null)
    {
        $resource_map = $this->__prepareResource($resource);
        $permissions = $this->collectPermissions($user);
        return $this->__compareResourceWithPermissions($resource_map, $permissions);
    }


    /**
     * Create new permission to database, and return it's id, or false if permission exists
     *
     * @param $area
     * @param $permission
     * @param array $actions
     * @param string $description
     * @return mixed
     */
    public function createPermission($area, $permission, array $actions = null, $description = '')
    {

        $area = (string) $area;
        $permission = (string) $permission;
        $description = (string) $description;

        return $this->repository->createPermission($area, $permission, $actions, $description);
    }

    /**
     * Add new permission to database, and return it's id, or false if permission exists
     *
     * @param $area
     * @param $permission
     * @param array $actions
     * @return mixed
     */
    public function deletePermission($area, $permission = null, $actions = null)
    {

        $area = (string) $area;
        $permission = ($permission !== null) ? (string) $permission : null;

        return $this->repository->deletePermission($area, $permission, $actions);
    }

    /**
     * Grant user permission to specific actions
     *
     * @param PermissionInterface $permission
     * @param UserInterface $user
     * @param array $actions
     * @param bool $overwrite , if false and user - permission relation exists,
     *                        will throw \Signes\Acl\Exception\DuplicateEntry
     * @return mixed
     */
    public function grantUserPermission(
        PermissionInterface $permission,
        UserInterface $user,
        $actions = array(),
        $overwrite = false
    ) {

        if ($overwrite) {
            $this->revokeUserPermission($permission, $user);
        }

        return $this->repository->grantUserPermission($permission, $user, $actions);
    }

    /**
     * @param PermissionInterface $permission
     * @param UserInterface $user
     * @return mixed
     */
    public function revokeUserPermission(PermissionInterface $permission, UserInterface $user)
    {
        return $this->repository->revokeUserPermission($permission, $user);
    }

    /**
     * Grant group permission to specific actions
     *
     * @param PermissionInterface $permission
     * @param GroupInterface $group
     * @param array $actions
     * @param bool $overwrite , if false and user - permission relation exists,
     *                        will throw \Signes\Acl\Exception\DuplicateEntry
     * @return mixed
     */
    public function grantGroupPermission(
        PermissionInterface $permission,
        GroupInterface $group,
        $actions = array(),
        $overwrite = false
    ) {

        if ($overwrite) {
            $this->revokeGroupPermission($permission, $group);
        }

        return $this->repository->grantGroupPermission($permission, $group, $actions);
    }

    /**
     * @param PermissionInterface $permission
     * @param GroupInterface $group
     * @return mixed
     */
    public function revokeGroupPermission(PermissionInterface $permission, GroupInterface $group)
    {
        return $this->repository->revokeGroupPermission($permission, $group);
    }

    /**
     * Grant user permission to specific actions
     *
     * @param PermissionInterface $permission
     * @param RoleInterface $role
     * @param array $actions
     * @param bool $overwrite , if false and user - permission relation exists,
     *                        will throw \Signes\Acl\Exception\DuplicateEntry
     * @return mixed
     */
    public function grantRolePermission(
        PermissionInterface $permission,
        RoleInterface $role,
        $actions = array(),
        $overwrite = false
    ) {

        if ($overwrite) {
            $this->revokeRolePermission($permission, $role);
        }

        return $this->repository->grantRolePermission($permission, $role, $actions);
    }

    /**
     * @param PermissionInterface $permission
     * @param RoleInterface $role
     * @return mixed
     */
    public function revokeRolePermission(PermissionInterface $permission, RoleInterface $role)
    {
        return $this->repository->revokeRolePermission($permission, $role);
    }
}
