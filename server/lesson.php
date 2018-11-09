<?php
namespace EAMann\ContactManager\Server\Lesson;

use League\Route\Http\Exception\UnauthorizedException;

function getAllContacts($offset = 0, $limit = 10) : array
{
    return [];
}

function createContact($contact) : object
{
    return new \stdClass();
}

function findContacts($queryParams) : array
{
    return [];
}

function getContact($id) : object
{
    return new \stdClass();
}

function updateContact($id) : object
{
    return new \stdClass();
}

function deleteContact($id) : bool
{
    return true;
}

// Registration and authentication

function register($username, $password) : void
{

}

function login($username, $password) : void
{

}