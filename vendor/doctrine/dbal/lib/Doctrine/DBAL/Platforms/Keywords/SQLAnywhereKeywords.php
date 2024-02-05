<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace Doctrine\DBAL\Platforms\Keywords;

/**
 * SAP Sybase SQL Anywhere 10 reserved keywords list.
 *
 * @author Steve Müller <st.mueller@dzh-online.de>
 */
class SQLAnywhereKeywords extends KeywordList
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'SQLAnywhere';
    }

    /**
     * {@inheritdoc}
     *
     * @link http://infocenter.sybase.com/help/topic/com.sybase.dbrfen10/pdf/dbrfen10.pdf?noframes=true
     */
    protected function getKeywords()
    {
        return [
            'ADD',
            'ALL',
            'ALTER',
            'AND',
            'ANY',
            'AS',
            'ASC',
            'ATTACH',
            'BACKUP',
            'BEGIN',
            'BETWEEN',
            'BIGINT',
            'BINARY',
            'BIT',
            'BOTTOM',
            'BREAK',
            'BY',
            'CALL',
            'CAPABILITY',
            'CASCADE',
            'CASE',
            'CAST',
            'CHAR',
            'CHAR_CONVERT',
            'CHARACTER',
            'CHECK',
            'CHECKPOINT',
            'CLOSE',
            'COMMENT',
            'COMMIT',
            'COMPRESSED',
            'CONFLICT',
            'CONNECT',
            'CONSTRAINT',
            'CONTAINS',
            'CONTINUE',
            'CONVERT',
            'CREATE',
            'CROSS',
            'CUBE',
            'CURRENT',
            'CURRENT_TIMESTAMP',
            'CURRENT_USER',
            'CURSOR',
            'DATE',
            'DBSPACE',
            'DEALLOCATE',
            'DEC',
            'DECIMAL',
            'DECLARE',
            'DEFAULT',
            'DELETE',
            'DELETING',
            'DESC',
            'DETACH',
            'DISTINCT',
            'DO',
            'DOUBLE',
            'DROP',
            'DYNAMIC',
            'ELSE',
            'ELSEIF',
            'ENCRYPTED',
            'END',
            'ENDIF',
            'ESCAPE',
            'EXCEPT',
            'EXCEPTION',
            'EXEC',
            'EXECUTE',
            'EXISTING',
            'EXISTS',
            'EXTERNLOGIN',
            'FETCH',
            'FIRST',
            'FLOAT',
            'FOR',
            'FORCE',
            'FOREIGN',
            'FORWARD',
            'FROM',
            'FULL',
            'GOTO',
            'GRANT',
            'GROUP',
            'HAVING',
            'HOLDLOCK',
            'IDENTIFIED',
            'IF',
            'IN',
            'INDEX',
            'INDEX_LPAREN',
            'INNER',
            'INOUT',
            'INSENSITIVE',
            'INSERT',
            'INSERTING',
            'INSTALL',
            'INSTEAD',
            'INT',
            'INTEGER',
            'INTEGRATED',
            'INTERSECT',
            'INTO',
            'IQ',
            'IS',
            'ISOLATION',
            'JOIN',
            'KERBEROS',
            'KEY',
            'LATERAL',
            'LEFT',
            'LIKE',
            'LOCK',
            'LOGIN',
            'LONG',
            'MATCH',
            'MEMBERSHIP',
            'MESSAGE',
            'MODE',
            'MODIFY',
            'NATURAL',
            'NCHAR',
            'NEW',
            'NO',
            'NOHOLDLOCK',
            'NOT',
            'NOTIFY',
            'NULL',
            'NUMERIC',
            'NVARCHAR',
            'OF',
            'OFF',
            'ON',
            'OPEN',
            'OPTION',
            'OPTIONS',
            'OR',
            'ORDER',
            'OTHERS',
            'OUT',
            'OUTER',
            'OVER',
            'PASSTHROUGH',
            'PRECISION',
            'PREPARE',
            'PRIMARY',
            'PRINT',
            'PRIVILEGES',
            'PROC',
            'PROCEDURE',
            'PUBLICATION',
            'RAISERROR',
            'READTEXT',
            'REAL',
            'REFERENCE',
            'REFERENCES',
            'REFRESH',
            'RELEASE',
            'REMOTE',
            'REMOVE',
            'RENAME',
            'REORGANIZE',
            'RESOURCE',
            'RESTORE',
            'RESTRICT',
            'RETURN',
            'REVOKE',
            'RIGHT',
            'ROLLBACK',
            'ROLLUP',
            'SAVE',
            'SAVEPOINT',
            'SCROLL',
            'SELECT',
            'SENSITIVE',
            'SESSION',
            'SET',
            'SETUSER',
            'SHARE',
            'SMALLINT',
            'SOME',
            'SQLCODE',
            'SQLSTATE',
            'START',
            'STOP',
            'SUBTRANS',
            'SUBTRANSACTION',
            'SYNCHRONIZE',
            'SYNTAX_ERROR',
            'TABLE',
            'TEMPORARY',
            'THEN',
            'TIME',
            'TIMESTAMP',
            'TINYINT',
            'TO',
            'TOP',
            'TRAN',
            'TRIGGER',
            'TRUNCATE',
            'TSEQUAL',
            'UNBOUNDED',
            'UNION',
            'UNIQUE',
            'UNIQUEIDENTIFIER',
            'UNKNOWN',
            'UNSIGNED',
            'UPDATE',
            'UPDATING',
            'USER',
            'USING',
            'VALIDATE',
            'VALUES',
            'VARBINARY',
            'VARBIT',
            'VARCHAR',
            'VARIABLE',
            'VARYING',
            'VIEW',
            'WAIT',
            'WAITFOR',
            'WHEN',
            'WHERE',
            'WHILE',
            'WINDOW',
            'WITH',
            'WITH_CUBE',
            'WITH_LPAREN',
            'WITH_ROLLUP',
            'WITHIN',
            'WORK',
            'WRITETEXT',
            'XML'
        ];
    }
}
