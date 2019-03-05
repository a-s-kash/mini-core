<?php

//d([
//    'answer_tough_question View',
//    $miniLinks
//]);

?>

<div style="    position: absolute;
    padding: 15px;
    padding-left: 25px;"><a href="/">Главная</a></div>

<div style="    padding-top: 50px;
    padding-bottom: 50px;">
    <h1 style="text-align: center;">Статистика переходов по ссылкам</h1>
</div>


<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Оригинальная ссылка</th>
        <th scope="col">Минимизированная ссылка</th>
        <th scope="col">Доступна до</th>
        <th scope="col">Количетво переходов</th>
    </tr>
    </thead>
    <tbody>
    <?php /** @var \models\entity\MiniLink $miniLink */ ?>
    <?php foreach ($miniLinks as $miniLink): ?>
        <tr>
            <th scope="row"><?= ++$i ?></th>
            <td><?= mb_strimwidth($miniLink->getOriginalLink(), 0, 80, "...") ?></td>
            <td>
                <a href="/<?= str_replace('-', '', $miniLink->getMinimizedLinkKey()) ?>" target="_blank">
                    <?= $miniLink->minimizedLink ?>
                </a>
            </td>
            <td style="<?= $miniLink->timeIsOver ? 'color: red;' : ''?>">
                <?= \core\App::currentDateTime()->setTimestamp($miniLink->getLifeTime())->format('Y-m-d H:i') ?>
            </td>
            <td><?= $miniLink->clickLinksCount ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>