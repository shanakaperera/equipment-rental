<?php

namespace Modules\Core\Http\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;

trait AlertTrait
{
    use LivewireAlert;

    protected $toastDuration = 3000;
    protected $toastWidth = '300';
    protected $toastPosition = 'top-end';
    protected $customClass = 'colored-toast';

    protected function showSuccessToast($message)
    {
        $this->alert('success', $message, [
            'position'         => $this->toastPosition,
            'background'       => '#20c997',
            'iconColor'        => '#FFFFFF',
            'customClass'      => ['popup' => $this->customClass],
            'timer'            => $this->toastDuration,
            'timerProgressBar' => true,
            'toast'            => true,
            'width'            => $this->toastWidth,
        ]);
    }

    protected function showErrorToast($message)
    {
        $this->alert('error', $message, [
            'position'         => $this->toastPosition,
            'background'       => '#f27474',
            'iconColor'        => '#FFFFFF',
            'customClass'      => ['popup' => $this->customClass],
            'timer'            => $this->toastDuration,
            'timerProgressBar' => true,
            'toast'            => true,
            'width'            => $this->toastWidth,
        ]);
    }

    protected function showInfoToast($message)
    {
        $this->alert('info', $message, [
            'position'         => $this->toastPosition,
            'background'       => '#3fc3ee',
            'iconColor'        => '#FFFFFF',
            'customClass'      => ['popup' => $this->customClass],
            'timer'            => $this->toastDuration,
            'timerProgressBar' => true,
            'toast'            => true,
            'width'            => $this->toastWidth,
        ]);
    }

    protected function showWarningToast($message)
    {
        $this->alert('warning', $message, [
            'position'         => $this->toastPosition,
            'background'       => '#f8bb86',
            'iconColor'        => '#FFFFFF',
            'customClass'      => ['popup' => $this->customClass],
            'timer'            => $this->toastDuration,
            'timerProgressBar' => true,
            'toast'            => true,
            'width'            => $this->toastWidth,
        ]);
    }
}
