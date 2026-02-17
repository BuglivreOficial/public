<?php
namespace Core\Logger;

class Log {
  public static function emergency() {}
  public static function alert() {}
  public static function critical() {}
  public static function error() {}
  public static function warning() {}
  public static function notice() {}
  public static function info() {}
  public static function debug() {}
}
/*
EMERGENCY ← sistema completamente quebrado
ALERT ← ação imediata necessária
CRITICAL ← falha crítica (banco fora, etc)
ERROR ← erro que precisa investigação
WARNING ← algo errado mas o sistema continua
NOTICE ← evento normal mas significativo
INFO ← informação geral do fluxo
DEBUG ← detalhes para desenvolvimento
*/