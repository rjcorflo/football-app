<?php

namespace RJ\PronosticApp\Util\General;

class ErrorCodes
{
    const DEFAULT = 0;

    const EXIST_PLAYER_EMAIL = 1;

    const EXIST_PLAYER_USERNAME = 2;

    const EXIST_COMMUNITY_NAME = 3;

    const INVALID_ID = 4;

    const INVALID_PLAYER_USERNAME = 5;

    const INVALID_PLAYER_PASSWORD = 6;

    const INVALID_PLAYER_EMAIL = 7;

    const INVALID_PLAYER_FIRSTNAME= 8;

    const INVALID_PLAYER_LASTNAME = 9;

    const INVALID_PLAYER_COLOR = 10;

    const INVALID_COMMUNITY_NAME = 11;

    const INVALID_COMMUNITY_PASSWORD = 12;

    const LOGIN_ERROR_INCORRECT_PASSWORD = 13;

    const LOGIN_ERROR_INCORRECT_USERNAME = 14;

    const INVALID_PLAYER_IDAVATAR = 15;

    const MISSING_PARAMETERS = 16;
}