<div class="row">
    <div class="col-md-4 order-md-2 mb-4">
        <div class="padding-t-10">
            <div style="border: 4px double black;" class="padding-1">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Текст тестового задания</span>
                </h4>

                <div>
                    <h6 class="my-0">Язык реализации PHP.</h6>
                    <small class="text-muted">Необходимо реализовать возможность ввода пользователем URL с целью минификации, и полем с указанием времени жизни ссылки. Сервис должен предоставлять статистику переходов по ссылке.</small>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8 order-md-1">
        <div class="padding-t-10">
            <div>
                <h2>Минификация ссылки</h2>
                <form action="/minimized-url" method="post">
                    <p>
                        <input type="url" style="width: 375px;" placeholder="Вставте ссылку" required name="MinimizedUrl[original_link]"/>
                    </p>

                    <p>
                        <input id="datetime" type="datetime-local" name="MinimizedUrl[life_time]" value="<?= $defaultLifeTime ?>"/>
                    </p>

                    <p><input type="submit" value="Минифицировать"/></p>
                </form>

                <?php if($minimizedLink): ?>
                    <p><?= $minimizedLink ?></p>
                <?php endif; ?>

                <?php if($errors): ?>

                    <p>ВНИМАНИЕ:</p>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li style="color: rgba(143,0,0,0.78);"><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <div class="padding-t-5">
                <h3><a class="btn btn-success" href="/minimized-url/statistics-following" role="button">Статистика переходов</a></h3>
            </div>
        </div>
    </div>
</div>
