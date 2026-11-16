<?php

namespace App\Ai\Agents;

use Laravel\Ai\Attributes\MaxTokens;
use Laravel\Ai\Attributes\Model;
use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Attributes\Temperature;
use Laravel\Ai\Attributes\Timeout;
use Laravel\Ai\Concerns\RemembersConversations;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Enums\Lab;
use Laravel\Ai\Promptable;
use Stringable;

#[Provider(Lab::Groq)]
#[Model('openai/gpt-oss-20b')]
#[Temperature(0.4)]
#[MaxTokens(500)]
#[Timeout(120)]
class CampusBuddy implements Agent, Conversational
{
    use Promptable, RemembersConversations;

    public function instructions(): Stringable|string
    {
        return 'You are CampusBuddy, a friendly study assistant for '
            . 'students of the College of Computing and Informatics, '
            . 'UNITEN, built by Osman Abdullahi. Help with study tips, '
            . 'programming and web development questions, and campus life. '
            . 'Keep answers under 150 words and use simple English. '
            . 'If you do not know something about UNITEN (dates, fees, '
            . 'rules), say so and suggest the official UNITEN website or '
            . 'the academic office. Never ask for passwords, IC numbers '
            . 'or other personal data.';
    }
}
