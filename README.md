# Wright Dev Test

## About Project

Hello friends! This is a solution for Wright20's dev test, question #4

I learned Livewire to solve this test and wanted to utilize some elements of Livewire and Livewire validation, as well as to make the solution usable without having to manually add a json file to the project, so I solved it by creating an input which allows users to enter up to 26 equations, each corresponding to a letter of the alphabet as a variable.

Users can enter equations one at a time, or separate them by commas. The equations are validated and then cleaned up. Errors are thrown when equations are invalid, or when the calculation is run, and it turns out that valildly formatted equations are unsolvable.

If I were to flesh this out further, some things to consider doing might be:
- Componentizing the front end elements such as buttons to be reusable
- Saving equations to a database
- Pulling out each equation into a livewire equation component, allowing users to delete or edit equations that have already been entered, and allowing users to re-run the calculator after making changes
- Maybe pulling out certain string parsing functionality into utilities so that they could be used across the app (assuming this would be a larger app)
- Maybe allow users to upload a json file with equations to be parsed and solved through the UI
- Add multiplication and division

## How To Run

- Clone this project to your local machine and `cd` into the project
- Run `composer install`
- Run `npm install`
- In one console tab, run `npm run dev` to build css and js
- In another console tab, run `php artisan serve` -- The project will be at the address given from this command


## Test Instructions From Wright20

We have created this test in hopes it allows candidates to demonstrate their strengths rather than using a
multiple-choice skills test. This test should take about two to three hours to complete and should be a bit of fun. We
strongly encourage you to focus on your strengths when choosing an approach; however, keep in mind it will be easier for
us to evaluate your ability to hit the ground running with our existing tech stack if you use the tools from our
existing stack listed in the job description (Laravel, PHP, Vue).

You may use existing libraries, tools, or frameworks; however, you MUST include a readme which should describe the steps
required to run your test response on a generic environment. You are encouraged to utilize any online resource you would
normally be able to access during a typical work day: google, stack overflow answers, documentation, reference material,
etc... You should not allow another person to assist your response in any way. You may be disqualified if you post any
part of the challenge to stack overflow or other forums. Be prepared to answer questions about your submission during a
technical interview. We will find out if you don't know your own code.

A final note on the use of AI: we currently implement generative AI tools in our team; however, the long-term
viability of these tools within the team is still in question given concerns about regulation, security, privacy, and
IP. You are welcome to use AI tools to complete this test. However, we will prefer candidates who demonstrate the
ability to use AI tools to augment their own abilities rather than replace them in the event we need to pivot away from
AI tools in the future.

Getting Help from Wright
------------------------
Please let us know if:

- You have a disability which hinders completion or delivery of your solution
- You feel you need more time to complete this test for any reason
- You need clarification or have questions about this test

You can reach us via email at jsteelman@wright20.com

Instructions:
------------

1. Choose a task which you believe will best demonstrate your programming ability.
2. Initialize the project with a git repo and commit your work as you go.
3. Create a readme with instructions on how to run your project. Please be sure to specify the versions of any language,
   framework, or tool your solution requires in the setup.
4. Make a private repo on github and invite github user `jksteelman` to view the project.
5. Email `jsteelman@wright20.com` to check out your submission with a link to your repo.

Scoring Rubric
--------------
Of a total 100pts:

- 30: Solution Completeness
- 15: Solution Documentation and Readability
- 15: Challenge Difficulty
- 10: Completed on time
- 10: Solution Creativity and Cleverness
- 10: Solution Readme Completeness
- 10: Solution includes PHPUnit, Jest, Cypress, or other testing mechanism.

Challenge Task Options (Choose One)
----------------------

1. Build an interactive, single-round jeopardy board using http://jservice.io/. You can create whatever interactivity
   you are comfortable with to track right/wrong answers. Presentational creativity is encouraged while providing
   sufficient functional code to demonstrate your ability.

2. Make a mind map visualization of https://rickandmortyapi.com/ by location, resident relationships, universe, episode,
   species, and/or status. The difficulty of this task will be determined by the complexity of the relationships
   inferred by the presentation. Presentational creativity is encouraged while providing sufficient functional code
   to demonstrate your ability.

3. Create a hidden-word puzzle solver given a provided array of strings which represents a puzzle, such as:
     ```json
       [
           "GQPVMISSIOSSTUDVUWMSE",
           "REGIUSVICTRIXSDUCUNIA",
           "NUNQUEMIMPERIPHPUMADI",
           "URIASVJLUMINCUBICULEM",
           "ASSIVDVSERGTSOPERENRH"
       ]
     ```

   and a given set of words like:

     ```json
       [
         "VUEJS",
         "PHP",
         "REDIS",
         "POSTGRES"
       ] 
     ```

   The result should be the original puzzle except we want to only see the answers by replacing the non-word-answers in
   the haystack replaced with a `*`. For example:

     ```json
       [
         "***V***************S*",
         "****U**************I*",
         "*****E*******PHP***D*",
         "******J************E*",
         "*******SERGTSOP****R*"
       ]
     ```
    - The words may appear forwards, backward, up, down, or diagonally.
    - Characters may be shared by other words (the S in VueJS is shared with Postgres, for example)
    - The max puzzle size is 316x316 or 10^5 search characters.

4. Make a simple equation solver from input strings like:
     ```json
       {
         "a": "2 + 10",
         "b": "a+4",
         "c": "a + b -1"
       }
     ```
   with output something like:

       a: 12
       b: 16
       c: 27

    - The equations will only ever contain addition or subtraction. Multiplication, division, and any other
      operators should return null or error.
    - The equations will only ever reference variables from preceding lines in the same payload.
    - Input spacing may be inconsistent
    - If the equation cannot be solved or is mal-formed, the output for the line should be `null`.
    - Note, we're not looking for Gaussian Elimination, we're looking for something that parses strings.
    - Note, there are PHP and JS Math-String Parsing Libraries which could solve this problem with relative ease;
      however, the result would not have enough work to evaluate a candidate's coding ability.   
