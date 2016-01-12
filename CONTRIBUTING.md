## TODO-List

1. Bootstrapping happens in index.php, test/bootstrap.php and various files in tools/
always very similarly. This behaviour could be extracted into an own class that then
is used in each files with simple calls like ```$bootstrap->readConfig()``` or similar.
However is is important that this Bootstrap class can't require anything only available
after bootstrapping.

2. File access and HTTP access must be set up properly so no outside user can see sensitive
information like credentials. While this theoretically should be the case already, a proper
analysis/review of the various angles of attack is necessary.

3. The phpunit.xml is probably not set up correctly yet. Currently all developer working on
this project can't integrate the unit tests into their IDE anyway, so this is not a priority but
it would be nice to have for future collaborators. At the moment testing works by calling the
script ```run_tests.sh```

4. The README needs love.

5. A build/install system/script needs to be set up.

6. If/when additional persisted objects other than Definition are required, it is probably
wise to first think about adding an ORM system or at least a persistence layer.

7. autoload.php of Glossary should use a generated classmap and also support multiple/internal
classes in one file.

8. The method ajaxAction of Glossary\Controller\Definition should not exit early, but somehow
use the existing MVC structure. Maybe something with disableHeaderFooter?

9. The keyword detection in Glossary\Definition\Format::formatDescription will become costly
the more keywords are recognized. Maybe it's possible to do this when creating new definitions
and save the rendered result. However this will have the problem, that rendered descriptions
possibly need to be re-rendered when new definitions are created. It could also be that doing
it on every request is in fact faster if the database queries can be minimized otherwise.

10. The keyword detection currently works fine, but is probably not perfect. An analysis should
be done in which cases the detection fails or provides false positives and if this will become
a problem.

11. There is no logger. Why is there no logger?

12. Slim already provides functionality to turn warnings and errors into catchable exceptions, so
there should be mechanism that catches exceptions that bubble up to the global scope and instead
of printing it to the user, should log these exceptions. The use is then shown a generic error
page. This is necessary so exceptions accidentally showing sensitive data (like database credentials),
are not shown to arbitrary users. It also makes debugging easier when all errors/warnings are logged.

13. The template currently works with a pre-content, content, post-content structure. This is not ideal
and should be replaced by something that allows the custom content output to be buffered and
injected into a general page template.