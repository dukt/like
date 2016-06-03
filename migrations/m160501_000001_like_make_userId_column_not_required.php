<?php
namespace Craft;

/**
 * The class name is the UTC timestamp in the format of mYYMMDD_HHMMSS_pluginHandle_migrationName
 */
class m160501_000001_like_make_userId_column_not_required extends BaseMigration
{
    /**
     * Any migration code in here is wrapped inside of a transaction.
     *
     * @return bool
     */
    public function safeUp()
    {
        // Make the userId column not required
        craft()->db->createCommand()->dropForeignKey('likes', 'userId');
        craft()->db->createCommand()->alterColumn('likes', 'userId', array(ColumnType::Int, 'null' => true));
        craft()->db->createCommand()->addForeignKey('likes', 'userId', 'users', 'id', 'SET NULL', null);

        return true;
    }
}
