<?php declare(strict_types = 1); // atom

namespace Netmosfera\Drawbridge;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

use Error;

//[][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][][]

/**
 * Thrown when the given type cannot be emulated.
 *
 * Specifically, it is thrown when the given type is not a `class`, or it is a `final class`
 * or a `class` containing `final` methods
 */
class CannotEmulateType extends Error
{}
