<?php

namespace App\Policies;

use App\Models\ExportProductsQueue;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExportProductsQueuePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * @param User $user
     * @param ExportProductsQueue $exportProductsQueue
     * @return bool
     */
    public function view(User $user, ExportProductsQueue $exportProductsQueue)
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * @param User $user
     * @param ExportProductsQueue $exportProductsQueue
     * @return bool
     */
    public function update(User $user,  ExportProductsQueue $exportProductsQueue)
    {
        return false;
    }

    /**
     * @param User $user
     * @param ExportProductsQueue $exportProductsQueue
     * @return false
     */
    public function delete(User $user,  ExportProductsQueue $exportProductsQueue)
    {
        return false;
    }

    /**
     * @param User $user
     * @param ExportProductsQueue $exportProductsQueue
     */
    public function restore(User $user,  ExportProductsQueue $exportProductsQueue)
    {
        //
    }

    /**
     * @param User $user
     * @param ExportProductsQueue $exportProductsQueue
     */
    public function forceDelete(User $user,  ExportProductsQueue $exportProductsQueue)
    {
        //
    }
}
