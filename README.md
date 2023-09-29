
# larastan-enum-crash

An example project to show an issue in phpstan/larastan around creating a laravel
macro that uses an enum as a default parameter.

## Issue

Here's the call stack (absolute path removed for brevity):
```
Internal error: Internal error: Invalid value in file /app/Providers/AppServiceProvider.php                                                                                                                                    

#0 phar:///vendor/phpstan/phpstan/phpstan.phar/vendor/nikic/php-parser/lib/PhpParser/Builder/Param.php(38): PhpParser\BuilderHelpers::normalizeValue(Object(App\Enums\SearchMatchType))                                        
#1 phar:///vendor/phpstan/phpstan/phpstan.phar/vendor/ondrejmirtes/better-reflection/src/SourceLocator/SourceStubber/ReflectionSourceStubber.php(484): PhpParser\Builder\Param->setDefault(Object(App\Enums\SearchMatchType))  
#2 phar:///vendor/phpstan/phpstan/phpstan.phar/vendor/ondrejmirtes/better-reflection/src/SourceLocator/SourceStubber/ReflectionSourceStubber.php(449):                                                                         
PHPStan\BetterReflection\SourceLocator\SourceStubber\ReflectionSourceStubber->setParameterDefaultValue(Object(ReflectionParameter), Object(PhpParser\Builder\Param))                                                                                                     
#3 phar:///vendor/phpstan/phpstan/phpstan.phar/vendor/ondrejmirtes/better-reflection/src/SourceLocator/SourceStubber/ReflectionSourceStubber.php(128):                                                                         
PHPStan\BetterReflection\SourceLocator\SourceStubber\ReflectionSourceStubber->addParameters(Object(PhpParser\Builder\Function_), Object(ReflectionFunction))                                                                                                             
#4 phar:///vendor/phpstan/phpstan/phpstan.phar/src/Type/ClosureTypeFactory.php(57):                                                                                                                                            
PHPStan\BetterReflection\SourceLocator\SourceStubber\ReflectionSourceStubber->generateFunctionStubFromReflection(Object(ReflectionFunction))                                                                                                                             
#5 /vendor/nunomaduro/larastan/src/Methods/MacroMethodsClassReflectionExtension.php(136): PHPStan\Type\ClosureTypeFactory->fromClosureObject(Object(Closure))                                                                  
#6 /vendor/nunomaduro/larastan/src/Methods/BuilderHelper.php(140): NunoMaduro\Larastan\Methods\MacroMethodsClassReflectionExtension->hasMethod(Object(PHPStan\Reflection\ClassReflection), 'whereLike')                        
#7 /vendor/nunomaduro/larastan/src/Methods/EloquentBuilderForwardsCallsExtension.php(103): NunoMaduro\Larastan\Methods\BuilderHelper->searchOnEloquentBuilder(Object(PHPStan\Reflection\ClassReflection), 'whereLike',         
Object(PHPStan\Reflection\ClassReflection))                                                                                                                                                                                                                              
#8 /vendor/nunomaduro/larastan/src/Methods/EloquentBuilderForwardsCallsExtension.php(54): NunoMaduro\Larastan\Methods\EloquentBuilderForwardsCallsExtension->findMethod(Object(PHPStan\Reflection\ClassReflection),            
'whereLike')                                                                                                                                                                                                                                                             
#9 /vendor/nunomaduro/larastan/src/Methods/ModelForwardsCallsExtension.php(215): NunoMaduro\Larastan\Methods\EloquentBuilderForwardsCallsExtension->hasMethod(Object(PHPStan\Reflection\ClassReflection), 'whereLike')         
#10 /vendor/nunomaduro/larastan/src/Methods/ModelForwardsCallsExtension.php(65): NunoMaduro\Larastan\Methods\ModelForwardsCallsExtension->findMethod(Object(PHPStan\Reflection\ClassReflection), 'whereLike')                  
#11 phar:///vendor/phpstan/phpstan/phpstan.phar/src/Reflection/ClassReflection.php(445): NunoMaduro\Larastan\Methods\ModelForwardsCallsExtension->hasMethod(Object(PHPStan\Reflection\ClassReflection), 'whereLike')           
#12 phar:///vendor/phpstan/phpstan/phpstan.phar/src/Type/ObjectType.php(551): PHPStan\Reflection\ClassReflection->hasMethod('whereLike')                                                                                       
#13 phar:///vendor/phpstan/phpstan/phpstan.phar/src/Rules/Methods/CallToStaticMethodStatementWithoutSideEffectsRule.php(69): PHPStan\Type\ObjectType->hasMethod('whereLike')                                                   
#14 phar:///vendor/phpstan/phpstan/phpstan.phar/src/Analyser/FileAnalyser.php(107): PHPStan\Rules\Methods\CallToStaticMethodStatementWithoutSideEffectsRule->processNode(Object(PhpParser\Node\Stmt\Expression),               
Object(PHPStan\Analyser\MutatingScope))                                                                                                                                                                                                                                  
#15 phar:///vendor/phpstan/phpstan/phpstan.phar/src/Node/ClassStatementsGatherer.php(108): PHPStan\Analyser\FileAnalyser->PHPStan\Analyser\{closure}(Object(PhpParser\Node\Stmt\Expression),                                   
Object(PHPStan\Analyser\MutatingScope))                                                                                                                                                                                                                                  
#16 phar:///vendor/phpstan/phpstan/phpstan.phar/src/Analyser/NodeScopeResolver.php(542): PHPStan\Node\ClassStatementsGatherer->__invoke(Object(PhpParser\Node\Stmt\Expression), Object(PHPStan\Analyser\MutatingScope))        
#17 phar:///vendor/phpstan/phpstan/phpstan.phar/src/Analyser/NodeScopeResolver.php(444): PHPStan\Analyser\NodeScopeResolver::PHPStan\Analyser\{closure}(Object(PhpParser\Node\Stmt\Expression),                                
Object(PHPStan\Analyser\MutatingScope))                                                                                                                                                                                                                                  
#18 phar:///vendor/phpstan/phpstan/phpstan.phar/src/Analyser/NodeScopeResolver.php(387): PHPStan\Analyser\NodeScopeResolver->processStmtNode(Object(PhpParser\Node\Stmt\Expression), Object(PHPStan\Analyser\MutatingScope),   
Object(Closure), Object(PHPStan\Analyser\StatementContext))                                                                                                                                                                                                              
#19 phar:///vendor/phpstan/phpstan/phpstan.phar/src/Analyser/NodeScopeResolver.php(541): PHPStan\Analyser\NodeScopeResolver->processStmtNodes(Object(PhpParser\Node\Stmt\ClassMethod), Array,                                  
Object(PHPStan\Analyser\MutatingScope), Object(Closure), Object(PHPStan\Analyser\StatementContext))                                                                                                                                                                      
#20 phar:///vendor/phpstan/phpstan/phpstan.phar/src/Analyser/NodeScopeResolver.php(387): PHPStan\Analyser\NodeScopeResolver->processStmtNode(Object(PhpParser\Node\Stmt\ClassMethod), Object(PHPStan\Analyser\MutatingScope),  
Object(PHPStan\Node\ClassStatementsGatherer), Object(PHPStan\Analyser\StatementContext))                                                                                                                                                                                 
#21 phar:///vendor/phpstan/phpstan/phpstan.phar/src/Analyser/NodeScopeResolver.php(643): PHPStan\Analyser\NodeScopeResolver->processStmtNodes(Object(PhpParser\Node\Stmt\Class_), Array,                                       
Object(PHPStan\Analyser\MutatingScope), Object(PHPStan\Node\ClassStatementsGatherer), Object(PHPStan\Analyser\StatementContext))                                                                                                                                         
#22 phar:///vendor/phpstan/phpstan/phpstan.phar/src/Analyser/NodeScopeResolver.php(387): PHPStan\Analyser\NodeScopeResolver->processStmtNode(Object(PhpParser\Node\Stmt\Class_), Object(PHPStan\Analyser\MutatingScope),       
Object(Closure), Object(PHPStan\Analyser\StatementContext))                                                                                                                                                                                                              
#23 phar:///vendor/phpstan/phpstan/phpstan.phar/src/Analyser/NodeScopeResolver.php(615): PHPStan\Analyser\NodeScopeResolver->processStmtNodes(Object(PhpParser\Node\Stmt\Namespace_), Array,                                   
Object(PHPStan\Analyser\MutatingScope), Object(Closure), Object(PHPStan\Analyser\StatementContext))                                                                                                                                                                      
#24 phar:///vendor/phpstan/phpstan/phpstan.phar/src/Analyser/NodeScopeResolver.php(356): PHPStan\Analyser\NodeScopeResolver->processStmtNode(Object(PhpParser\Node\Stmt\Namespace_), Object(PHPStan\Analyser\MutatingScope),   
Object(Closure), Object(PHPStan\Analyser\StatementContext))                                                                                                                                                                                                              
#25 phar:///vendor/phpstan/phpstan/phpstan.phar/src/Analyser/FileAnalyser.php(166): PHPStan\Analyser\NodeScopeResolver->processNodes(Array, Object(PHPStan\Analyser\MutatingScope), Object(Closure))                           
#26 phar:///vendor/phpstan/phpstan/phpstan.phar/src/Command/WorkerCommand.php(132): PHPStan\Analyser\FileAnalyser->analyseFile('/Volumes/code/e...', Array, Object(PHPStan\Rules\LazyRegistry),                                
Object(PHPStan\Collectors\Registry), NULL)                                                                                                                                                                                                                               
#27 phar:///vendor/phpstan/phpstan/phpstan.phar/vendor/evenement/evenement/src/Evenement/EventEmitterTrait.php(97): PHPStan\Command\WorkerCommand->PHPStan\Command\{closure}(Array)                                            
#28 phar:///vendor/phpstan/phpstan/phpstan.phar/vendor/clue/ndjson-react/src/Decoder.php(117): _PHPStan_5b84f9f0d\Evenement\EventEmitter->emit('data', Array)                                                                  
#29 phar:///vendor/phpstan/phpstan/phpstan.phar/vendor/evenement/evenement/src/Evenement/EventEmitterTrait.php(97): _PHPStan_5b84f9f0d\Clue\React\NDJson\Decoder->handleData(Array)                                            
#30 phar:///vendor/phpstan/phpstan/phpstan.phar/vendor/react/stream/src/Util.php(62): _PHPStan_5b84f9f0d\Evenement\EventEmitter->emit('data', Array)                                                                           
#31 phar:///vendor/phpstan/phpstan/phpstan.phar/vendor/evenement/evenement/src/Evenement/EventEmitterTrait.php(97): _PHPStan_5b84f9f0d\React\Stream\Util::_PHPStan_5b84f9f0d\React\Stream\{closure}('{"action":"anal...')      
#32 phar:///vendor/phpstan/phpstan/phpstan.phar/vendor/react/stream/src/DuplexResourceStream.php(154): _PHPStan_5b84f9f0d\Evenement\EventEmitter->emit('data', Array)                                                          
#33 phar:///vendor/phpstan/phpstan/phpstan.phar/vendor/react/event-loop/src/StreamSelectLoop.php(201): _PHPStan_5b84f9f0d\React\Stream\DuplexResourceStream->handleData(Resource id #5694)                                     
#34 phar:///vendor/phpstan/phpstan/phpstan.phar/vendor/react/event-loop/src/StreamSelectLoop.php(173): _PHPStan_5b84f9f0d\React\EventLoop\StreamSelectLoop->waitForStreamActivity(NULL)                                        
#35 phar:///vendor/phpstan/phpstan/phpstan.phar/src/Command/WorkerCommand.php(98): _PHPStan_5b84f9f0d\React\EventLoop\StreamSelectLoop->run()                                                                                  
#36 phar:///vendor/phpstan/phpstan/phpstan.phar/vendor/symfony/console/Command/Command.php(259): PHPStan\Command\WorkerCommand->execute(Object(_PHPStan_5b84f9f0d\Symfony\Component\Console\Input\ArgvInput),                  
Object(_PHPStan_5b84f9f0d\Symfony\Component\Console\Output\ConsoleOutput))                                                                                                                                                                                               
#37 phar:///vendor/phpstan/phpstan/phpstan.phar/vendor/symfony/console/Application.php(870):                                                                                                                                   
_PHPStan_5b84f9f0d\Symfony\Component\Console\Command\Command->run(Object(_PHPStan_5b84f9f0d\Symfony\Component\Console\Input\ArgvInput), Object(_PHPStan_5b84f9f0d\Symfony\Component\Console\Output\ConsoleOutput))                                                       
#38 phar:///vendor/phpstan/phpstan/phpstan.phar/vendor/symfony/console/Application.php(261): _PHPStan_5b84f9f0d\Symfony\Component\Console\Application->doRunCommand(Object(PHPStan\Command\WorkerCommand),                     
Object(_PHPStan_5b84f9f0d\Symfony\Component\Console\Input\ArgvInput), Object(_PHPStan_5b84f9f0d\Symfony\Component\Console\Output\ConsoleOutput))                                                                                                                         
#39 phar:///vendor/phpstan/phpstan/phpstan.phar/vendor/symfony/console/Application.php(157):                                                                                                                                   
_PHPStan_5b84f9f0d\Symfony\Component\Console\Application->doRun(Object(_PHPStan_5b84f9f0d\Symfony\Component\Console\Input\ArgvInput), Object(_PHPStan_5b84f9f0d\Symfony\Component\Console\Output\ConsoleOutput))                                                         
#40 phar:///vendor/phpstan/phpstan/phpstan.phar/bin/phpstan(124): _PHPStan_5b84f9f0d\Symfony\Component\Console\Application->run()                                                                                              
#41 phar:///vendor/phpstan/phpstan/phpstan.phar/bin/phpstan(125): _PHPStan_5b84f9f0d\{closure}()                                                                                                                               
#42 /vendor/phpstan/phpstan/phpstan(8): require('phar:///Volumes...')                                                                                                                                                          
#43 /vendor/bin/phpstan(119): include('/Volumes/code/e...')                                                                                                                                                                    
#44 {main}                                                                                                                                                                                                                                                               
Child process error (exit code 1):
```

To see the issue yourself, run:
```bash
./vendor/bin/phpstan -v
```

## Setup

This project was created using the following commands:
```bash
curl -s "https://laravel.build/larastan-enum-crash?with=none" | bash
cd larastan-enum-crash
composer require --dev phpstan/phpstan nunomaduro/larastan
# Add phpstan.neon, app/Enums/SearchMatchType.php, and add macro to app/Providers/AppServiceProvider.php
```

