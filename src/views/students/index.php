         <div class="row">
              <div class="col-md-6">
                  <strong>Список студентов</strong>
              </div>
              <div class="col-md-6 text-right">
                  <form role="form" class="form-inline" action="/" method="GET">
                      <div class="form-group">
                          <input placeholder="Поиск" class="form-control" type="text" name="find">
                      </div>
                      <button type="submit" class="btn btn-success">Найти</button>
                  </form> 
              </div>
          </div>
<br />
          <div class="row">
               <table class="table">
                   <thead>
                        <tr>
                           <th>Имя</th>
                           <th>Фамилия</th>
                           <th>Номер группы</th>
                           <th>Баллов</th>
                        </tr>
                   </thead>
                   <?php foreach ($params['students'] as $student): ?>
                       <tr>
                           <td><?=htmlspecialchars($student['name'], ENT_QUOTES)?></td>
                           <td><?=htmlspecialchars($student['lastname'], ENT_QUOTES)?></td>
                           <td><?=htmlspecialchars($student['groupnum'], ENT_QUOTES)?></td>
                           <td><?=htmlspecialchars($student['ege'], ENT_QUOTES)?></td>
                       <tr>
                   <?php endforeach; ?>
               </table>
          </div>
    <div class="row">
        <div class="col-md-11">
            <ul class="pagination">
                <?php if(isset($params['paginatorData'])): ?>
                <?php \src\helpers\Paginator::paginate($params['paginatorData']);?>
                <?php endif?>
            </ul>
        </div>
        
    </div>
    <a href="add">Добавить себя в список</a>
</div>