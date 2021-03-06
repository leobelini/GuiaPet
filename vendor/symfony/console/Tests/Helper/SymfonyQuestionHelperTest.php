<?php

namespace Symfony\Component\Console\Tests\Helper;

use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\SymfonyQuestionHelper;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\Console\Question\ChoiceQuestion;

/**
 * @group tty
 */
class SymfonyQuestionHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testAskChoice()
    {
        $questionHelper = new SymfonyQuestionHelper();

        $helperSet = new HelperSet(array(new FormatterHelper()));
        $questionHelper->setHelperSet($helperSet);

        $heroes = array('Superman', 'Batman', 'Spiderman');

        $questionHelper->setInputStream($this->getInputStream("\n1\n  1  \nFabien\n1\nFabien\n1\n0,2\n 0 , 2  \n\n\n"));

        $question = new ChoiceQuestion('What is your favorite superhero?', $heroes, '2');
        $question->setMaxAttempts(1);
        // first answer is an empty answer, we're supposed to receive the default value
        $this->assertEquals('Spiderman', $questionHelper->ask($this->createInputInterfaceMock(), $output = $this->createOutputInterface(), $question));
        $this->assertOutputContains('What is your favorite superhero? [Spiderman]', $output);

        $question = new ChoiceQuestion('What is your favorite superhero?', $heroes);
        $question->setMaxAttempts(1);
        $this->assertEquals('Batman', $questionHelper->ask($this->createInputInterfaceMock(), $this->createOutputInterface(), $question));
        $this->assertEquals('Batman', $questionHelper->ask($this->createInputInterfaceMock(), $this->createOutputInterface(), $question));

        $question = new ChoiceQuestion('What is your favorite superhero?', $heroes);
        $question->setErrorMessage('Input "%s" is not a superhero!');
        $question->setMaxAttempts(2);
        $this->assertEquals('Batman', $questionHelper->ask($this->createInputInterfaceMock(), $output = $this->createOutputInterface(), $question));
        $this->assertOutputContains('Input "Fabien" is not a superhero!', $output);

        try {
            $question = new ChoiceQuestion('What is your favorite superhero?', $heroes, '1');
            $question->setMaxAttempts(1);
            $questionHelper->ask($this->createInputInterfaceMock(), $output = $this->createOutputInterface(), $question);
            $this->fail();
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals('Value "Fabien" is invalid', $e->getMessage());
        }

        $question = new ChoiceQuestion('What is your favorite superhero?', $heroes, null);
        $question->setMaxAttempts(1);
        $question->setMultiselect(true);

        $this->assertEquals(array('Batman'), $questionHelper->ask($this->createInputInterfaceMock(), $this->createOutputInterface(), $question));
        $this->assertEquals(array('Superman', 'Spiderman'), $questionHelper->ask($this->createInputInterfaceMock(), $this->createOutputInterface(), $question));
        $this->assertEquals(array('Superman', 'Spiderman'), $questionHelper->ask($this->createInputInterfaceMock(), $this->createOutputInterface(), $question));

        $question = new ChoiceQuestion('What is your favorite superhero?', $heroes, '0,1');
        $question->setMaxAttempts(1);
        $question->setMultiselect(true);

        $this->assertEquals(array('Superman', 'Batman'), $questionHelper->ask($this->createInputInterfaceMock(), $output = $this->createOutputInterface(), $question));
        $this->assertOutputContains('What is your favorite superhero? [Superman, Batman]', $output);

        $question = new ChoiceQuestion('What is your favorite superhero?', $heroes, ' 0 , 1 ');
        $question->setMaxAttempts(1);
        $question->setMultiselect(true);

        $this->assertEquals(array('Superman', 'Batman'), $questionHelper->ask($this->createInputInterfaceMock(), $output = $this->createOutputInterface(), $question));
        $this->assertOutputContains('What is your favorite superhero? [Superman, Batman]', $output);
    }

    protected function getInputStream($input)
    {
        $stream = fopen('php://memory', 'r+', false);
        fwrite($stream, $input);
        rewind($stream);

        return $stream;
    }

    protected function createInputInterfaceMock($interactive = true)
    {
        $mock = $this->getMock('Symfony\Component\Console\Input\InputInterface');
        $mock->expects($this->any())
            ->method('isInteractive')
            ->will($this->returnValue($interactive));

        return $mock;
    }

    protected function createOutputInterface()
    {
        $output = new StreamOutput(fopen('php://memory', 'r+', false));
        $output->setDecorated(false);

        return $output;
    }

    private function assertOutputContains($expected, StreamOutput $output)
    {
        rewind($output->getStream());
        $stream = stream_get_contents($output->getStream());
        $this->assertContains($expected, $stream);
    }
}
