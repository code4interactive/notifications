@extends('platform::template.layout')
@section('header')
    <h1>Lista tokenów</h1>
@stop
@section('content')
    <script>
        $(function () {
            $("#submit_button").click(function () {
                $('.smart-form').submit(); //submit form
                $('button').prop('disabled', true);
            });

            $('.modal').on('hidden', function () {
                $(this).data('modal', null);
            });
            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });

        });
    </script>
    {{ HTML::style('/assets/css/bs.css') }}

    <?php


    $dg = new \Code4\Platform\Support\DataGrid('/cui/token/lista', 'main', array(
            array(
                    'id' => 'actions',
                    'label' => "",
                    'width' => '10px',
                    'sortable' => false,
                    'searchable' => false,
                    'selectRow' => true,
                    'selectAll' => true
            ),

            array(
                    'id' => 'identyfikator',
                    'label' => "Identyfikator",
            ),
            array(
                    'id' => 'sn',
                    'label' => "Numer seryjny",
                    'sortDirection' => 'desc',
            ),

            array(
                    'id' => 'nazwa_jednostki',
                    'label' => "Jednostka",
            ),
            array(
                    'id' => 'nazwa_klienta',
                    'label' => "Nazwa klienta",
            ),


            array(
                    'id' => 'toolsColumn',
                    'label' => 'Akcja',
                    'sortable' => false,
                    'searchable' => false)
    ));


    $dg->toolsColumn()->setDecorator(function ($object) {
        return '<a href="/cui/token/edytuj/[[id]]" class="btn bg-color-green txt-color-white btn-xs"><i class="fa fa-edit"></i> Edytuj</a>';
    });
    $dg->actions()->setDecorator(function ($object) {
        return addCheckbox('[[id]]');
    });

    $dg->actions()->setHeaderDecorator(function ($object) {
        return addCheckbox('all');
    });
    $dg->setDataGridId('_token');

    ?>
    <form id="tokeny" name="tokeny_lista" action="xxx" method="post">
        <?php $dg->render(); ?>


        <div id="jednostka">
            <section>

            </section>
        </div>
        <div data-widget-deletebutton="false" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-colorbutton="false" id="wid-id-0" class="jarviswidget jarviswidget-color-blue jarviswidget-sortable" style="" role="widget">
            <header role="heading">
                <div class="jarviswidget-ctrls" role="menu">
                    <a data-placement="bottom" title="" rel="tooltip" class="button-icon jarviswidget-fullscreen-btn" href="javascript:void(0);" data-original-title="Fullscreen"><i class="fa fa-resize-full "></i></a>
                </div>
                <span class="widget-icon"> <i class="fa fa-comments"></i> </span>

                <h2>Zmiana jednostki wybranych tokenów </h2>
            </header>


            <div role="content">

                <div class="widget-body">


                    <div class="alert alert-info">
                        <i class="fa fa-exclamation"></i> Zaznacz w powyższej tabeli tokeny, które mają być przeniesione a następnie wybierz z listy jednostek, jednostkę docelową i kliknij przycisk
                        <code>Zapisz</code>
                    </div>


                    <label class="label">Przekaż do</label>

                    <div id="jednostki" style="width: 250px;">
                        <select name="jednostka_id" id="jednostka_id" class="select2" style="width:250px">

                            <?php
                            foreach ($jednostki as $row) {

                                echo '<option value="' . $row->id . '">' . $row->nazwa . '</option>';
                            }?>

                        </select>
                        <input type="submit" value="Zapisz" data-confirm="Czy jesteś pewny, że chcesz wykonać tą operację ?" class="btn btn-primary btn-lg" id="submitButton">
                    </div>


                </div>


            </div>


        </div>
    </form>
@stop