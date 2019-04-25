export PGPASSWORD='secret'
sudo -u postgres dropdb registry_2
sudo -u postgres createdb registry_2 --owner=homestead
psql -U homestead -h localhost registry_2 < buildserver-registry.sql
