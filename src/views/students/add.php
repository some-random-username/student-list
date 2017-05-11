<form role="form" action="add" method='POST'>
    <div class="form-group">
        <label for="name">Имя</label>
        <input type="text" name="name" class="form-control" required value="<?=@htmlspecialchars($params['values']['name'], ENT_QUOTES);?>">
    </div>
    <div class="form-group">
        <label for="lastname">Фамилия</label>
        <input type="text" name="lastname" class="form-control" required value="<?=@htmlspecialchars($params['values']['lastname'], ENT_QUOTES);?>">
    </div>
    <label for="gender">Пол</label>
    <select name="gender" class="form-control" required>        
        <option value="male">Мужской</option>
        <option value="female">Женский</option>
    </select>
    <br/>
    <div class="form-group">
        <label for="groupnum">Номер группы</label>
        <input type="text" name="groupnum" class="form-control" required value="<?=@htmlspecialchars($params['values']['groupnum'], ENT_QUOTES);?>">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" class="form-control" required value="<?=@htmlspecialchars($params['values']['email'], ENT_QUOTES);?>">
    </div>
    <div class="form-group">
        <label for="email">Баллы</label>
        <input type="number" name="ege" class="form-control" required value="<?=@htmlspecialchars($params['values']['ege'], ENT_QUOTES);?>">
    </div>
    <div class="form-group">
        <label for="email">Год рождения</label>
        <input type="number" name="birth" class="form-control" required value="<?=@htmlspecialchars($params['values']['birth'], ENT_QUOTES);?>">
    </div>
    <label for="local">Пол</label>
    <select name="local" class="form-control" required >        
        <option value="local">Местный</option>
        <option value="foreign">Иногородний</option>
    </select>
    <br/>
    <?php if(isset($params['errors'])):?>
    <?='<p class="text-danger">' . array_shift($params['errors']) . '</p>';?>
    <?php endif;?>
    <button type="submit" class="btn btn-success">Подтвердить</button>
</form>
