<?php

namespace Modules\Translation\Datatables\TableView;

use Carbon\Carbon;
use Modules\Translation\Entities\TranslationLanguage;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields\Text;
use Yajra\DataTables\Services\DataTable;

class TranslationLanguageDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->setRowId('id')
            ->editColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->format('Y-m-d');
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \Modules\Translation\Entities\TranslationLanguage
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(TranslationLanguage $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     * @throws \Exception
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('translation-languages-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1, 'ASC')
            ->select('single')
            ->responsive()
            ->pageLength(20)
            ->buttons(
                Button::make('create')->editor('editor'),
                Button::make('edit')->editor('editor'),
                Button::make('remove')->editor('editor')->className('remove-btn'),
                Button::make('edit')->editor('editor')->text('<i class="fas fa-language"></i> Translations')
                    ->action('function(e, dt, node, config) { let url = \'' . route('admin.translations.index', ':lang') . '\'; url = url.replace(\':lang\', dt.rows({selected:true}).data()[0].slug); window.location.href = url; }'),
                Button::make('')->text('<i class="fas fa-sync-alt"></i>  Reload')->action('function(e, dt, node, config){ dt.draw(false); }')
            )->editor(
                Editor::make()->fields([
                    Text::make('lang_name')->label('Language'),
                    Text::make('slug')->id('slug'),
                ])->onOpen('function(){ $("#slug").attr("onkeyup", "this.value=this.value.replace(/[^a-z]/g,\'\');"); }')
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('lang_name')->title('Language'),
            Column::make('slug'),
            Column::make('created_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'TranslationLanguage_' . date('YmdHis');
    }
}
