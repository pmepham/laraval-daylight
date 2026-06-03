<?php

namespace App\View\Components\layout\components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DatatableActions extends Component
{
    public ?string $viewUrl;
    public ?string $editUrl;
    public ?string $editClass;
    public ?string $archiveClass;
    public ?string $deleteClass;
    public ?string $attribute;
    public string|int|null $id;

    public function __construct(
        string $viewUrl = null,
        string $editUrl = null,
        string $editClass = null,
        string $archiveClass = null,
        string $deleteClass = null,
        string $attribute = 'id',
        string|int $id = null,
    ) {
        $this->viewUrl = $viewUrl;
        $this->editUrl = $editUrl;
        $this->editClass = $editClass;
        $this->archiveClass = $archiveClass;
        $this->deleteClass = $deleteClass;
        $this->attribute = $attribute;
        $this->id = $id;
    }

    public function render()
    {
        return view('components.datatable.actions');
    }
}
