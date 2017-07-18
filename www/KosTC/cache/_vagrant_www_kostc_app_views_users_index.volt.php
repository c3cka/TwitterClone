<?= $this->getContent() ?>
<?= $this->tag->form(['users/login', 'method' => 'post', 'autocomplete' => 'off']) ?>
<h1>Users</h1>
<div>
    <label for="username">Username</label>
    <?= $this->tag->textField(['username', 'size' => 30]) ?>
</div>
<div>
    <label for="password">Password</label>
    <?= $this->tag->passwordField(['password', 'size' => 30]) ?>
</div>
<?= $this->tag->submitButton(['Login', 'class' => 'btn']) ?>
<?= $this->tag->endForm() ?>