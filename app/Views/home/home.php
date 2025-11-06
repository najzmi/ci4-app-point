
        <?= $this->extend('layout/admin') ?>
        <?= $this->section('content') ?>
            <div class="row">
                <div class="col">
                    <div class="card border border-secondary-subtle">
                        <div class="card-body">
                            <div class="heroe">
                                <h1>Welcome to CodeIgniter <?= CodeIgniter\CodeIgniter::CI_VERSION ?></h1>
                                <h2>The small framework with powerful features</h2>
                            </div>
                            </hr>
                            <section>
                                <h1>About this page</h1>

                                <p>The page you are looking at is being generated dynamically by CodeIgniter.</p>

                                <p>If you would like to edit this page you will find it located at:</p>

                                <pre><code>app/Views/welcome_message.php</code></pre>

                                <p>The corresponding controller for this page can be found at:</p>

                                <pre><code>app/Controllers/Home.php</code></pre>

                            </section>
                                <!-- FOOTER: DEBUG INFO + COPYRIGHTS -->

                            <footer>
                                <div class="environment">

                                    <p>Page rendered in {elapsed_time} seconds using {memory_usage} MB of memory.</p>

                                    <p>Environment: <?= ENVIRONMENT ?></p>

                                </div>

                                <div class="copyrights">

                                    <p>&copy; <?= date('Y') ?> CodeIgniter Foundation. CodeIgniter is open source project released under the MIT
                                        open source licence.</p>

                                </div>

                            </footer>
                        </div>
                    </div>
                </div>
            </div>
        <?= $this->endSection();?>
